<?php

namespace App\Services\Scraper\Crawler;

use App\Services\Scraper\Crawler\Dto\CrawlJobDto;
use App\Services\Scraper\Crawler\Dto\PaginationDto;

class CrawlerContext
{
    public function __construct(
        public readonly CrawlJobDto $job,
    ) {}

    /**
     * HTML downloaded by FetchMiddleware.
     */
    public ?string $html = null;

    /**
     * Category created by CategoryMiddleware.
     */
    public ?int $categoryId = null;

    /**
     * Pagination result created by PaginationMiddleware.
     */
    public ?PaginationDto $pagination = null;

    /**
     * Used by middleware to stop further processing.
     */
    public bool $stop = false;

    /**
     * Used for passing config infoes.
     */
    public array $config = [];

    public int $pageLimit = 0;
    public int $itemsLimit = 0;

    public bool $onlySubCategories = false;
    public string $currentUrl = '';
}
