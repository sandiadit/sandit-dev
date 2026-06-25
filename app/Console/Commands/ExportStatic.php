<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ExportStatic extends Command
{
    protected $signature = 'export:static
                            {--skip-build : Skip npm run build}
                            {--skip-push  : Export saja, tidak push ke GitHub}
                            {--message=   : Custom commit message}';

    protected $description = 'Export Laravel ke HTML statis lalu push ke GitHub Pages';

    // Base URL server lokal yang sedang jalan
    private string $baseUrl;

    // Folder output hasil export
    private string $distPath;

    // Semua URL yang sudah dikunjungi (hindari duplikat)
    private array $visited = [];

    // Antrian URL yang akan di-crawl
    private array $queue = [];

    // Route publik sebagai titik awal crawl
    private array $seedPaths = [
        '/',
        '/projects',
        '/certificates',
        '/contact',
    ];

    public function handle(): int
    {
        $this->baseUrl = rtrim(env('STATIC_EXPORT_BASE_URL', 'http://127.0.0.1:8000'), '/');
        $this->distPath = base_path('docs');

        $this->printHeader();

        // ── 1. Build assets ──────────────────────────────────────────────────
        if (!$this->option('skip-build')) {
            if (!$this->buildAssets())
                return self::FAILURE;
        } else {
            $this->warn('   ⏭  Build assets di-skip');
        }

        // ── 2. Bersihkan dist/ ───────────────────────────────────────────────
        $this->cleanDist();

        // ── 3. Crawl & simpan halaman ────────────────────────────────────────
        if (!$this->crawlPages())
            return self::FAILURE;

        // ── 4. Copy static assets (build/, favicon) ──────────────────────────
        $this->copyAssets();

        // ── 5. Copy gambar dari storage ──────────────────────────────────────
        $this->copyStorage();

        // ── 6. Push ke GitHub ────────────────────────────────────────────────
        if (!$this->option('skip-push')) {
            if (!$this->pushToGithub())
                return self::FAILURE;
        } else {
            $this->warn('   ⏭  Push ke GitHub di-skip');
        }

        $this->printSuccess();
        return self::SUCCESS;
    }

    // ────────────────────────────────────────────────────────────────────────
    // BUILD ASSETS
    // ────────────────────────────────────────────────────────────────────────

    private function buildAssets(): bool
    {
        $this->info('');
        $this->info('📦  [1/5] Building assets (npm run build)...');

        exec('npm run build 2>&1', $output, $code);

        if ($code !== 0) {
            $this->error('❌  npm run build gagal!');
            $this->line(implode("\n", $output));
            return false;
        }

        $this->info('   ✓ Assets berhasil di-build');
        return true;
    }

    // ────────────────────────────────────────────────────────────────────────
    // BERSIHKAN DIST
    // ────────────────────────────────────────────────────────────────────────

    private function cleanDist(): void
    {
        $this->info('');
        $this->info('🧹  [2/5] Membersihkan folder dist/...');

        if (File::exists($this->distPath)) {
            collect(File::directories($this->distPath))
                ->reject(fn($dir) => basename($dir) === '.git')
                ->each(fn($dir) => File::deleteDirectory($dir));

            collect(File::files($this->distPath))
                ->reject(fn($file) => in_array($file->getFilename(), ['.gitkeep', 'CNAME']))
                ->each(fn($file) => File::delete($file->getPathname()));
        } else {
            File::makeDirectory($this->distPath, 0755, true);
        }

        $this->info('   ✓ dist/ bersih');
    }

    // ────────────────────────────────────────────────────────────────────────
    // CRAWL HALAMAN
    // ────────────────────────────────────────────────────────────────────────

    private function crawlPages(): bool
    {
        $this->info('');
        $this->info('🔄  [3/5] Crawling & menyimpan halaman...');

        // Cek apakah server lokal sedang jalan
        if (!$this->isServerRunning()) {
            $this->error('❌  Server lokal tidak berjalan!');
            $this->error('   Jalankan dulu: php artisan serve');
            return false;
        }

        // Seed antrian dengan route publik
        foreach ($this->seedPaths as $path) {
            $this->queue[] = $path;
        }

        $savedCount = 0;

        while (!empty($this->queue)) {
            $path = array_shift($this->queue);

            // Skip kalau sudah dikunjungi
            if (in_array($path, $this->visited))
                continue;

            // Skip route non-publik
            if ($this->shouldSkip($path)) {
                $this->visited[] = $path;
                continue;
            }

            $this->visited[] = $path;

            $url = $this->baseUrl . $path;
            $html = $this->fetchPage($url);

            if ($html === null) {
                $this->warn("   ⚠  Gagal fetch: {$path}");
                continue;
            }

            // Simpan HTML ke dist/
            $this->savePage($path, $html);
            $savedCount++;

            $this->line("   → Saved: {$path}");

            // Ekstrak link baru dari halaman ini
            $this->extractLinks($html, $path);
        }

        $this->info("   ✓ {$savedCount} halaman berhasil di-export");
        return true;
    }

    private function isServerRunning(): bool
    {
        $parts = parse_url($this->baseUrl);
        $host = $parts['host'] ?? '127.0.0.1';
        $port = $parts['port'] ?? 80;

        $conn = @fsockopen($host, $port, $errno, $errstr, 3);

        if ($conn) {
            fclose($conn);
            return true;
        }

        return false;
    }

    private function fetchPage(string $url): ?string
    {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'ignore_errors' => true,
                'header' => "Accept: text/html\r\n",
            ],
        ]);

        $html = @file_get_contents($url, false, $context);

        // Ambil HTTP status code
        $statusLine = $http_response_header[0] ?? '';
        preg_match('/HTTP\/\d\.\d (\d{3})/', $statusLine, $matches);
        $statusCode = (int) ($matches[1] ?? 0);

        if ($statusCode !== 200 || $html === false) {
            return null;
        }

        return $html;
    }

    private function savePage(string $path, string $html): void
    {
        // / → dist/index.html
        // /projects → dist/projects/index.html
        // /projects/nama-project → dist/projects/nama-project/index.html

        if ($path === '/') {
            $filePath = $this->distPath . '/index.html';
        } else {
            $cleanPath = trim($path, '/');
            $dir = $this->distPath . '/' . $cleanPath;
            File::makeDirectory($dir, 0755, true, true);
            $filePath = $dir . '/index.html';
        }

        // Fix URL asset dari Vite yang hardcode localhost
        $html = str_replace($this->baseUrl . '/', '/', $html);
        $html = str_replace($this->baseUrl, '/', $html);
        $html = str_replace('http://localhost:8000/', '/', $html);
        $html = str_replace('http://localhost:8000', '/', $html);
        $html = str_replace('http://localhost/', '/', $html);
        $html = str_replace('http://localhost', '/', $html);

        File::put($filePath, $html);
    }

    private function extractLinks(string $html, string $currentPath): void
    {
        // Cari semua href dari tag <a>
        preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>/i', $html, $matches);

        foreach ($matches[1] as $href) {
            $href = trim($href);

            // Skip anchor, mailto, tel, external
            if (
                empty($href) ||
                str_starts_with($href, '#') ||
                str_starts_with($href, 'mailto:') ||
                str_starts_with($href, 'tel:') ||
                str_starts_with($href, 'http') ||
                str_starts_with($href, '//')
            ) {
                continue;
            }

            // Normalize path
            $path = '/' . ltrim($href, '/');

            // Hilangkan query string dan fragment
            $path = strtok($path, '?');
            $path = strtok($path, '#');

            if (!in_array($path, $this->visited) && !in_array($path, $this->queue)) {
                $this->queue[] = $path;
            }
        }
    }

    private function shouldSkip(string $path): bool
    {
        $skipPrefixes = [
            '/dashboard',
            '/login',
            '/register',
            '/logout',
            '/forgot-password',
            '/reset-password',
            '/email',
            '/profile',
        ];

        foreach ($skipPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        // Skip file extension non-HTML
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (in_array($ext, ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf'])) {
            return true;
        }

        return false;
    }

    // ────────────────────────────────────────────────────────────────────────
    // COPY STATIC ASSETS
    // ────────────────────────────────────────────────────────────────────────

    private function copyAssets(): void
    {
        $this->info('');
        $this->info('📂  [4/5] Menyalin static assets...');

        // Copy hasil Vite build
        $buildSrc = public_path('build');
        if (File::exists($buildSrc)) {
            File::copyDirectory($buildSrc, $this->distPath . '/build');
            $this->info('   ✓ build/ (CSS & JS) disalin');
        } else {
            $this->warn('   ⚠  Folder public/build tidak ditemukan, jalankan npm run build dulu');
        }

        // Copy favicon
        $faviconSrc = public_path('favicon.ico');
        if (File::exists($faviconSrc)) {
            File::copy($faviconSrc, $this->distPath . '/favicon.ico');
            $this->info('   ✓ favicon.ico disalin');
        }

        // Copy folder public/images jika ada
        $imagesSrc = public_path('images');
        if (File::exists($imagesSrc)) {
            File::copyDirectory($imagesSrc, $this->distPath . '/images');
            $this->info('   ✓ images/ disalin');
        }
    }

    // ────────────────────────────────────────────────────────────────────────
    // COPY STORAGE (foto profile, gambar sertifikat, dll)
    // ────────────────────────────────────────────────────────────────────────

    private function copyStorage(): void
    {
        $storageSrc = storage_path('app/public');

        if (!File::exists($storageSrc)) {
            $this->warn('   ⚠  storage/app/public tidak ditemukan, dilewati');
            return;
        }

        $storageDest = $this->distPath . '/storage';
        File::copyDirectory($storageSrc, $storageDest);

        $count = count(File::allFiles($storageDest));
        $this->info("   ✓ {$count} file storage disalin ke dist/storage/");
    }

    // ────────────────────────────────────────────────────────────────────────
    // PUSH KE GITHUB
    // ────────────────────────────────────────────────────────────────────────

    private function pushToGithub(): bool
    {
        $this->info('');
        $this->info('📤  [5/5] Push ke GitHub...');

        $message = $this->option('message') ?: 'deploy: ' . now()->format('Y-m-d H:i:s');

        exec('git add docs/ 2>&1', $addOut, $addCode);

        $messageEscaped = escapeshellarg($message);
        exec("git commit -m {$messageEscaped} 2>&1", $commitOut, $commitCode);

        $commitMsg = implode('', $commitOut);
        if ($commitCode !== 0 && !str_contains($commitMsg, 'nothing to commit')) {
            $this->error('❌  Git commit gagal!');
            $this->line($commitMsg);
            return false;
        }

        if (str_contains($commitMsg, 'nothing to commit')) {
            $this->warn('   ⚠  Tidak ada perubahan untuk di-commit');
            return true;
        }

        exec('git push 2>&1', $pushOut, $pushCode);

        if ($pushCode !== 0) {
            $this->error('❌  Git push gagal!');
            $this->line(implode("\n", $pushOut));
            return false;
        }

        $this->info('   ✓ Berhasil push ke GitHub');
        return true;
    }

    // ────────────────────────────────────────────────────────────────────────
    // HELPERS
    // ────────────────────────────────────────────────────────────────────────

    private function printHeader(): void
    {
        $this->info('');
        $this->info('┌──────────────────────────────────────┐');
        $this->info('│   🚀  Export Static — sandit.my.id   │');
        $this->info('└──────────────────────────────────────┘');
    }

    private function printSuccess(): void
    {
        $this->info('');
        $this->info('┌──────────────────────────────────────────────┐');
        $this->info('│  ✅  Deploy selesai!                          │');
        $this->info('│  🌐  https://sandit.my.id                     │');
        $this->info('│  ⏱   Live dalam ~1-2 menit di GitHub Pages   │');
        $this->info('└──────────────────────────────────────────────┘');
        $this->info('');
    }
}