<?php

namespace App\Services\Scraper\Crawler\Pipeline\Middleware;

use App\Services\Fetch\FetchService;
use Browser\Services\Browser\BrowserService;
use Closure;
use App\Services\Scraper\Crawler\CrawlerContext;
use App\Services\Scraper\Crawler\Pipeline\Contracts\CrawlerMiddleware;

class FetchMiddleware implements CrawlerMiddleware
{
    public function __construct(
        private readonly FetchService $browser,
    ) {}

    public function handle(
        CrawlerContext $context,
        Closure $next,
    ): void {

        $response = $this->browser->openPage(
            $context->job->url,
            $context
        )->response()->html;

        $context->html = $response;

        $next($context);
    }
}
