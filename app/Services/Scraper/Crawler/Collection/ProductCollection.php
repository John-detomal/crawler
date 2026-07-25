<?php

namespace App\Services\Scraper\Crawler\Collection;

use App\Services\Scraper\Crawler\Dto\PaginationDto;
use App\Services\Scraper\Crawler\Dto\ProductDto;

class ProductCollection
{
    /** @var array<string, ProductDto> */
    private array $products = [];

    /**
     * @param array<int, array{
     *     sku:string,
     *     url:string
     * }> $items
     * @param array<string, array> $foundIn
     */
    public function merge(
        PaginationDto $pagination,
        int $categoryId,
    ): void {
        foreach ($pagination->products as $item) {

            $sku = $item['sku'];

            if (!isset($this->products[$sku])) {

                $this->products[$sku] = new ProductDto(
                    sku: $sku,
                    url: $item['url'],
                    categoryIds: [$categoryId],
                );
            } elseif (
                !in_array(
                    $categoryId,
                    $this->products[$sku]->categoryIds,
                    true
                )
            ) {

                $this->products[$sku]
                    ->categoryIds[] = $categoryId;
            }

            if (isset($pagination->foundIn[$sku])) {
                $this->products[$sku]
                    ->foundIn[] = $pagination->foundIn[$sku];
            }
        }
    }

    public function find(string $sku): ?ProductDto
    {
        return $this->products[$sku] ?? null;
    }

    /**
     * @return ProductDto[]
     */
    public function all(): array
    {
        return array_values($this->products);
    }

    public function count(): int
    {
        return count($this->products);
    }

    public function clear(): void
    {
        $this->products = [];
    }
}
