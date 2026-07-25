<?php

namespace App\Services\Scraper\Crawler\Collection;

use App\Services\Scraper\Crawler\Dto\CategoryDto;
use App\Services\Scraper\Crawler\Dto\CrawlJobDto;
use App\Services\Scraper\Crawler\Dto\PaginationDto;

class CategoryCollection
{
    private int $nextId = 1;

    /** @var array<int, CategoryDto> */
    private array $categories = [];

    /** @var array<string, int> */
    private array $categoryMap = [];

    public function create(CrawlJobDto $job): int
    {
        if (isset($this->categoryMap[$job->url])) {
            return $this->categoryMap[$job->url];
        }

        $id = $this->nextId++;

        $this->categoryMap[$job->url] = $id;

        $this->categories[$id] = new CategoryDto(
            id: $id,
            name: $job->name ?? '',
            url: $job->url,
            parentId: $job->parentId,
        );

        return $id;
    }

    public function find(int $id): ?CategoryDto
    {
        return $this->categories[$id] ?? null;
    }

    public function updatePagination(
        PaginationDto $pagination,
        int $categoryId,
    ): void {
        $category = $this->find($categoryId);

        if ($category === null) {
            return;
        }

        $category->totalProducts = $pagination->totalProducts;
        $category->totalPages = $pagination->totalPages;
        $category->totalProductsCrawled = $pagination->totalProductsCrawled;
        $category->totalPagesCrawled = $pagination->totalPagesCrawled;
    }

    /**
     * @return CategoryDto[]
     */
    public function all(): array
    {
        return array_values($this->categories);
    }

    public function count(): int
    {
        return count($this->categories);
    }

    public function clear(): void
    {
        $this->nextId = 1;
        $this->categories = [];
        $this->categoryMap = [];
    }
}
