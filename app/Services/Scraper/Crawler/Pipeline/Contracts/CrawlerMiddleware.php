<?php

namespace App\Services\Scraper\Crawler\Pipeline\Contracts;

use Closure;
use App\Services\Scraper\Crawler\CrawlerContext;

interface CrawlerMiddleware
{
    public function handle(
        CrawlerContext $context,
        Closure $next
    ): void;
}
