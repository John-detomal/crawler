<?php

namespace App\Services\Scraper\Crawler\Pipeline\Middleware;

use Closure;
use App\Services\Scraper\Queue\UrlSeenRegistry;
use App\Services\Scraper\Crawler\CrawlerContext;
use App\Services\Scraper\Crawler\Pipeline\Contracts\CrawlerMiddleware;

class SeenMiddleware implements CrawlerMiddleware
{
    public function __construct(
        private readonly UrlSeenRegistry $seen,
    ) {}

    public function handle(
        CrawlerContext $context,
        Closure $next
    ): void {

        if (! $this->seen->remember($context->job->url)) {
            return;
        }

        $next($context);
    }
}
