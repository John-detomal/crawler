<?php

namespace App\Services\Fetch;

use App\Services\Scraper\Crawler\CrawlerContext;
use Browser\Services\Browser\BrowserService;
use Browser\Services\Browser\Middleware\Factory\PipelineFactory;
use Browser\Services\Browser\Pipeline\BrowserPipeline;
use Exception;
use Illuminate\Support\Facades\Redis;

class FetchService
{
    private BrowserService $browser;

    public function __construct(private readonly BrowserPipeline $pipeline)
    {
        $this->browser = new BrowserService($this->pipeline);
    }

    public function openPage(string $url, CrawlerContext $context)
    {
        try {
            $context->currentUrl = $url;
            $this->browser->openPage($url);

            return $this;
        } catch (Exception $e) {
            $this->saveUrl($context);

            throw new Exception($e->getMessage());
        }
    }

    public function saveUrl(CrawlerContext $context)
    {
        Redis::set('last-fetch-url', $context->currentUrl);
        Redis::set('last-fetch-id', $context->categoryId);
    }

    public function response()
    {
        return $this->browser->response();
    }
}
