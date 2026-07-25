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

    public function remember(string $url): bool
    {
        $hash = hash('xxh3', $url);

        if (isset($this->seen[$hash])) {
            return false;
        }

        $this->seen[$hash] = true;

        return true;
    }
}
