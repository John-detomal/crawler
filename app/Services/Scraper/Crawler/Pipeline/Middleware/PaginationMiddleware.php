<?php

namespace App\Services\Scraper\Crawler\Pipeline\Middleware;

use Closure;
use App\Services\Scraper\Crawler\CrawlerContext;
use App\Services\Scraper\Crawler\PaginationCrawler;
use App\Services\Scraper\Crawler\Collection\CategoryCollection;
use App\Services\Scraper\Crawler\Pipeline\Contracts\CrawlerMiddleware;

class PaginationMiddleware implements CrawlerMiddleware
{
    public function __construct(
        private readonly PaginationCrawler $crawler,
        private readonly CategoryCollection $categories,
    ) {}

    public function handle(
        CrawlerContext $context,
        Closure $next,
    ): void {

        $context->pagination = $this->crawler
            ->maxPages($context->pageLimit)
            ->run(
                html: $context->html,
                url: $context->job->url,
                config: $context->config['index_page'],
            );

        $this->categories->updatePagination(
            categoryId: $context->categoryId,
            pagination: $context->pagination,
        );

        $next($context);
    }
}
