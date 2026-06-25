<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Certificate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Default untuk Login Dashboard
        User::updateOrCreate(
            ['email' => 'admin@sandi.dev'],
            [
                'name' => 'Sandi Aditia',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Data Profil Diri
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'full_name' => 'Sandi Aditia',
                'headline' => 'Full-Stack Web Developer & Systems Analyst',
                'bio' => 'Passionate about building efficient web applications, digitizing workflows, and crafting seamless developer experiences.',
                'email' => 'sandiadit@gmail.com',
                'location' => 'Bandung, Indonesia',
                'photo' => null,
            ]
        );

        // 3. Data Pengalaman Kerja
        Experience::truncate();
        Experience::create([
            'title' => 'Full-Stack Developer',
            'company' => 'Freelance / Self-employed',
            'description' => 'Developing custom web systems using Laravel, CodeIgniter, and Vue.js. Helping clients automate and digitalize their business workflows.',
            'start_date' => '2024-01-01',
            'end_date' => null, // Present
        ]);

        Experience::create([
            'title' => 'Web Developer Intern',
            'company' => 'Tech Solutions',
            'description' => 'Maintained internal web portals, optimized SQL queries, and collaborated with senior developers on PHP-based microservices.',
            'start_date' => '2023-06-01',
            'end_date' => '2023-12-31',
        ]);

        // 4. Data Proyek Portofolio
        Project::truncate();
        Project::create([
            'title' => 'GAINS (Gauge In Out Systems)',
            'slug' => 'gains-gauge-in-out-systems',
            'description' => 'Integrated system transforming manual tool measurement tracking into a digital workflow, reducing tracking time by 50%.',
            'tech_stack' => 'CodeIgniter 4, Bootstrap, MySQL, JavaScript',
            'repo_url' => 'https://github.com/sandiadit/gains',
            'demo_url' => 'https://gains.sandi.dev',
            'status' => 'completed',
            'thumbnail' => null,
        ]);

        Project::create([
            'title' => 'Personal Hub Portfolio',
            'slug' => 'personal-hub-portfolio',
            'description' => 'Modern developer portfolio website with a local Laravel CMS backend and a static HTML crawler deployment workflow to GitHub Pages.',
            'tech_stack' => 'Laravel, Tailwind CSS, JavaScript, Vite',
            'repo_url' => 'https://github.com/sandiadit/sandi-dev',
            'demo_url' => 'https://sandit.my.id',
            'status' => 'ongoing',
            'thumbnail' => null,
        ]);

        // 5. Data Sertifikat
        Certificate::truncate();
        Certificate::create([
            'name' => 'Laravel Advanced Developer',
            'issuer' => 'Laracasts',
            'issued_date' => '2025-05-15',
            'expired_date' => null,
            'credential_url' => 'https://laracasts.com',
            'is_featured' => true,
            'image' => null,
        ]);

        Certificate::create([
            'name' => 'Database Design & Optimization',
            'issuer' => 'Udemy',
            'issued_date' => '2024-10-10',
            'expired_date' => null,
            'credential_url' => 'https://udemy.com',
            'is_featured' => false,
            'image' => null,
        ]);
    }
}
