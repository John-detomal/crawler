<?php

namespace App\Services\Scraper\Queue;

use App\Services\Scraper\Queue\UrlQueueInterface;
use SplQueue;
use App\Services\Scraper\Crawler\Dto\CrawlJobDto;

class UrlQueue implements UrlQueueInterface
{
    private SplQueue $queue;

    public function __construct()
    {
        $this->queue = new SplQueue();
    }

    public function push(CrawlJobDto $job): void
    {
        $this->queue->enqueue($job);
    }

    public function pushMany(array $jobs): void
    {
        foreach ($jobs as $job) {
            $this->push($job);
        }
    }

    public function pop(): ?CrawlJobDto
    {
        return $this->queue->isEmpty()
            ? null
            : $this->queue->dequeue();
    }

    public function has(): bool
    {
        return !$this->queue->isEmpty();
    }
}
