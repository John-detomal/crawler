<?php

namespace App\Providers;

use App\Services\Scraper\Crawler\CrawlerEngine;

use App\Services\Scraper\Crawler\Collection\CategoryCollection;
use App\Services\Scraper\Crawler\Collection\ProductCollection;

use App\Services\Scraper\Queue\UrlQueue;
use App\Services\Scraper\Queue\UrlQueueInterface;

use Illuminate\Support\ServiceProvider;
use App\Services\Scraper\Crawler\Pipeline\CrawlerPipelineFactory;
use App\Services\Scraper\Crawler\Pipeline\CrawlPipeline;
use Browser\Services\Browser\BrowserService;
use Browser\Services\Browser\Middleware\Factory\PipelineFactory;
use Browser\Services\Browser\Middleware\Registry\MiddlewareRegistry;
use Browser\Services\Browser\Pipeline\BrowserPipeline;

class ScraperServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerBrowser();

        //
        $this->app->singleton(CategoryCollection::class);
        $this->app->singleton(ProductCollection::class);

        $this->app->singleton(
            UrlQueueInterface::class,
            UrlQueue::class
        );

        $this->app->singleton(CrawlPipeline::class, function ($app) {
            return CrawlerPipelineFactory::make($app);
        });
        $this->app->singleton(CrawlerEngine::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}

    public function registerBrowser()
    {
        $this->app->singleton(BrowserService::class, function () {

            $factory = new PipelineFactory();

            $pipeline = new BrowserPipeline(
                MiddlewareRegistry::register($factory)
            );

            return new BrowserService($pipeline)->cache();
        });
    }
}
