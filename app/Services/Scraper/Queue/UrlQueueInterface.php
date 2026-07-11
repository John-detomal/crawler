<?php

namespace App\Services\Scraper\Queue;

use App\Services\Scraper\Crawler\Dto\CrawlJobDto;

interface UrlQueueInterface
{
    public function push(CrawlJobDto $job): void;
    public function pushMany(array $job): void;
    public function pop(): ?CrawlJobDto;
    public function has(): bool;
}
