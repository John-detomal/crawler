<?php

namespace App\Services\Scraper\Queue;

class UrlSeenRegistry
{
    private array $seen = [];

    public function has(string $url): bool
    {
        return isset($this->seen[hash('xxh3', $url)]);
    }

    public function add(string $url): void
    {
        $this->seen[hash('xxh3', $url)] = true;
    }
}
