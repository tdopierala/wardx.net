<?php

namespace App\Services;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownService
{
    protected MarkdownConverter $converter;

    public function __construct()
    {
        $environment = new Environment([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new TableExtension());
        $environment->addExtension(new AutolinkExtension());

        $this->converter = new MarkdownConverter($environment);
    }

    public function toHtml(string $markdown): string
    {
        return $this->converter->convert($markdown)->getContent();
    }

    public function estimateReadingTime(string $markdown): int
    {
        $wordCount = str_word_count(strip_tags($markdown));
        return max(1, (int) ceil($wordCount / 200));
    }
}
