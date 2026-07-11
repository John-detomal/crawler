<?php

namespace App\Services\Scraper\Traces\Parser;

class ParserTrace
{

    public function __construct(
        public string $type,
        public string $pattern,
        public int $count,
        public float $duration,
        public string $content,
    ) {}
}
