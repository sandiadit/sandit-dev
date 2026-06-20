<?php

use League\CommonMark\CommonMarkConverter;

function renderMarkdown(string $content): string
{
    $converter = new CommonMarkConverter([
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
    ]);

    return $converter->convert($content)->getContent();
}