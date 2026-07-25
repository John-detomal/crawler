<?php

namespace App\Services\Scraper\Crawler\Pipeline\Middleware;

use Closure;
use App\Services\Scraper\Collectors\SubCategory\SubCategoryCollector;
use App\Services\Scraper\Crawler\CrawlerContext;
use App\Services\Scraper\Crawler\Dto\CrawlJobDto;
use App\Services\Scraper\Crawler\Pipeline\Contracts\CrawlerMiddleware;
use App\Services\Scraper\Queue\UrlQueueInterface;

class SubCategoryMiddleware implements CrawlerMiddleware
{
    public function __construct(
        private readonly UrlQueueInterface $queue,
    ) {}

    public function handle(
        CrawlerContext $context,
        Closure $next,
    ): void {

        $children = SubCategoryCollector::collect(
            $context->html,
            $context->config['sub_category'],
            'https://th-pettersson.com'
        );

        if (empty($children)) {
            $next($context);
            return;
        }

        foreach ($children as $child) {

            $this->queue->push(
                new CrawlJobDto(
                    url: $child['url'],
                    name: $child['category_name'],
                    parentId: $context->categoryId,
                )
            );
        }
    }
}
