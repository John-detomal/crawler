<?php

namespace App\Services\Scraper\Crawler\Pipeline\Middleware;

use Closure;
use App\Services\Scraper\Crawler\CrawlerContext;
use App\Services\Scraper\Crawler\Pipeline\Contracts\CrawlerMiddleware;
use App\Services\Scraper\Crawler\Collection\ProductCollection;

class ProductMiddleware implements CrawlerMiddleware
{
    public function __construct(
        private readonly ProductCollection $products,
    ) {}

    public function handle(
        CrawlerContext $context,
        Closure $next,
    ): void {
        if ($context->pagination !== null) {
            $this->products->merge(
                pagination: $context->pagination,
                categoryId: $context->categoryId,
            );
        }

        $next($context);
    }
}
