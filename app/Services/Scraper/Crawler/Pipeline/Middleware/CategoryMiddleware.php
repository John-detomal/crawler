<?php

namespace App\Services\Scraper\Crawler\Pipeline\Middleware;

use Closure;
use App\Services\Scraper\Crawler\CrawlerContext;
use App\Services\Scraper\Crawler\Collection\CategoryCollection;
use App\Services\Scraper\Crawler\Pipeline\Contracts\CrawlerMiddleware;

class CategoryMiddleware implements CrawlerMiddleware
{
    public function __construct(
        private readonly CategoryCollection $categories,
    ) {}

    public function handle(
        CrawlerContext $context,
        Closure $next,
    ): void {

        $context->categoryId = $this->categories->create(
            $context->job
        );

        $next($context);
    }
}
