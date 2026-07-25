<?php

namespace App\Services\Scraper\Crawler;

use App\Services\Scraper\Crawler\CrawlerContext;
use App\Services\Scraper\Crawler\Pipeline\CrawlPipeline;
use App\Services\Scraper\Crawler\Collection\CategoryCollection;
use App\Services\Scraper\Crawler\Collection\ProductCollection;
use App\Services\Scraper\Queue\UrlQueueInterface;

class CrawlerEngine
{
    private bool $onlySubCategories = false;

    private int $itemsLimit = 0;

    private ?int $pageLimit = null;

    public function __construct(
        private readonly UrlQueueInterface $queue,
        private readonly CrawlPipeline $pipeline,
        private readonly CategoryCollection $categories,
        private readonly ProductCollection $products,
    ) {}

    public function seeds(array $jobs): self
    {
        $this->queue->pushMany($jobs);

        return $this;
    }

    public function maxPages(?int $limit): self
    {
        $this->pageLimit = $limit;

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->itemsLimit = $limit;

        return $this;
    }

    public function subCategories(
        bool $enabled = true
    ): self {

        $this->onlySubCategories = $enabled;

        return $this;
    }

    public function run(array $config): self
    {
        while ($job = $this->queue->pop()) {

            $context = new CrawlerContext(
                job: $job,
            );

            $context->config = $config;

            $context->pageLimit = $this->pageLimit;
            $context->itemsLimit = $this->itemsLimit;
            $context->onlySubCategories = $this->onlySubCategories;

            $this->pipeline->process($context);
        }

        return $this;
    }

    public function result(): array
    {
        return [
            'categories' => $this->categories->all(),
            'products' => $this->products->all(),
        ];
    }
}
