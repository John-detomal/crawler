<?php

namespace App\Services\Scraper\Crawler\Pipeline;

use App\Services\Scraper\Crawler\CrawlerContext;
use App\Services\Scraper\Crawler\Pipeline\Contracts\CrawlerMiddleware;
use Closure;

class CrawlPipeline
{
    /**
     * @param CrawlerMiddleware[] $middlewares
     */
    public function __construct(
        private readonly array $middlewares,
    ) {}

    public function process(CrawlerContext $context): void
    {
        $pipeline = array_reduce(
            array_reverse($this->middlewares),
            $this->carry(),
            static fn(CrawlerContext $context): mixed => null,
        );

        $pipeline($context);
    }

    private function carry(): Closure
    {
        return function (
            Closure $next,
            CrawlerMiddleware $middleware
        ): Closure {

            return function (
                CrawlerContext $context
            ) use (
                $next,
                $middleware
            ): void {

                $middleware->handle(
                    $context,
                    $next
                );
            };
        };
    }
}
