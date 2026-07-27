<?php

namespace App\Services\Scraper\Crawler\Pipeline;

use App\Services\Fetch\FetchService;
use Illuminate\Contracts\Foundation\Application;

use App\Services\Scraper\Crawler\Pipeline\Middleware\SeenMiddleware;
use App\Services\Scraper\Crawler\Pipeline\Middleware\CategoryMiddleware;
use App\Services\Scraper\Crawler\Pipeline\Middleware\FetchMiddleware;
use App\Services\Scraper\Crawler\Pipeline\Middleware\SubCategoryMiddleware;
use App\Services\Scraper\Crawler\Pipeline\Middleware\ProductMiddleware;

use App\Services\Scraper\Queue\UrlSeenRegistry;
use App\Services\Scraper\Queue\UrlQueueInterface;

use App\Services\Scraper\Crawler\Collection\CategoryCollection;
use App\Services\Scraper\Crawler\Collection\ProductCollection;
use App\Services\Scraper\Crawler\PaginationCrawler;
use App\Services\Scraper\Crawler\Pipeline\Middleware\PaginationMiddleware;

class CrawlerPipelineFactory
{
    public static function make(Application $app): CrawlPipeline
    {
        return new CrawlPipeline([
            new SeenMiddleware(new UrlSeenRegistry()),
            new CategoryMiddleware($app->make(CategoryCollection::class)),
            new FetchMiddleware($app->make(FetchService::class)),
            new SubCategoryMiddleware($app->make(UrlQueueInterface::class)),

            new PaginationMiddleware(
                $app->make(PaginationCrawler::class),
                $app->make(CategoryCollection::class)
            ),

            new ProductMiddleware($app->make(ProductCollection::class)),
        ]);
    }
}
