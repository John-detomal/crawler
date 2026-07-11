<?php

namespace App\Services\Scraper\Crawler;

use Browser\Services\Browser\BrowserService;
use App\Services\Scraper\Queue\UrlSeenRegistry;
use App\Services\Scraper\Collectors\SubCategory\SubCategoryCollector;
use App\Services\Scraper\Queue\UrlQueue;
use App\Services\Scraper\Crawler\Dto\CategoryDto;
use App\Services\Scraper\Crawler\Dto\ProductDto;
use App\Services\Scraper\Crawler\Dto\CrawlJobDto;
use App\Services\Scraper\Crawler\Crawler;

class CrawlerEngine
{
    use Crawler;
    private UrlQueue $queue;

    private UrlSeenRegistry $seen;

    private PaginationCrawler $paginationCrawler;

    private int $nextCategoryId = 1;

    /** @var CategoryDto[] */
    private array $categories = [];

    /** @var ProductDto[] */
    private array $products = [];

    /** @var array<string,int> */
    private array $categoryMap = [];

    private bool $onlySubcategories = false;
    private int $itemsLimit = 0;

    public function __construct(

        private BrowserService $browser,
    ) {
        $this->queue = new UrlQueue();
        $this->seen = new UrlSeenRegistry();
        $this->paginationCrawler = new PaginationCrawler(
            $browser
        );
    }

    public function seeds(array $jobs): self
    {
        foreach ($jobs as $job) {
            $this->queue->push($job);
        }

        return $this;
    }

    public function limit(int $limit)
    {
        $this->itemsLimit = $limit;
        return $this;
    }

    public function subCategories(bool $enabled = true): self
    {
        $this->onlySubcategories = $enabled;
        return $this;
    }

    public function run(array $config): self
    {
        while ($this->queue->has()) {

            /** @var CrawlJobDto $job */
            $job = $this->queue->pop();

            if ($job === null) {
                break;
            }

            if ($this->seen->has($job->url)) {
                continue;
            }

            $this->seen->add($job->url);

            $categoryId = $this->createCategory($job);

            $html = $this->fetch($job->url);

            $children = $this->collectChildren(
                $html,
                $config['sub_category']
            );

            if (!empty($children)) {
                foreach ($children as $child) {

                    $this->queue->push(
                        new CrawlJobDto(
                            url: $child['url'],
                            name: $child['category_name'],
                            parentId: $categoryId,
                        )
                    );
                }

                continue;
            } else {
                if (!$this->onlySubcategories) {
                    // if continue via retry get its parentid and use its url to check page numbers and pass its html
                    // - then on pagination proceed to the current url where it stops
                    // - then update the config to the latest number of pages but need to locate the pagination key or get the page number
                    // - todo create function to get what page number it stop or jsut simply track the current page number and use it to continue its optional field on the database
                    $pagination = $this->processPagination(
                        $html,
                        $job->url,
                        $config['index_page'],
                        $categoryId
                    );

                    if ($this->itemsLimit && count($pagination->products) >= $this->itemsLimit) {
                        return $this;
                    }
                }
            }
        }

        // for category process retry

        // if crash use record from db to push the queuue
        // do recursive until quuee is null

        return $this;
    }

    public function result(): array
    {
        return [
            'categories' => array_values(
                $this->categories
            ),
            'products' => array_values(
                $this->products
            ),
        ];
    }

    private function fetch(string $url): string
    {
        return $this->browser
            ->openPage($url)['content'];
    }

    private function createCategory(
        CrawlJobDto $job
    ): int {

        if (isset($this->categoryMap[$job->url])) {
            return $this->categoryMap[$job->url];
        }

        $id = $this->nextCategoryId++;

        $this->categoryMap[$job->url] = $id;

        $this->categories[$id] = new CategoryDto(
            id: $id,
            name: $job->name ?? '',
            url: $job->url,
            parentId: $job->parentId,
        );

        return $id;
    }

    private function collectChildren(
        string $html,
        array $config,
    ): array {
        return SubCategoryCollector::collect(
            $html,
            $config,
            'https://th-pettersson.com'
        );
    }

    private function attachProducts(
        array $items,
        int $categoryId,
        array $foundIn,
    ): void {

        foreach ($items as $item) {

            $sku = $item['sku'];

            if (!isset($this->products[$sku])) {

                $this->products[$sku] = new ProductDto(
                    sku: $sku,
                    url: $item['url'],
                    categoryIds: [$categoryId],
                );
            } else {

                if (!in_array(
                    $categoryId,
                    $this->products[$sku]->categoryIds,
                    true
                )) {
                    $this->products[$sku]
                        ->categoryIds[] = $categoryId;
                }
            }

            if (isset($foundIn[$sku])) {

                $this->products[$sku]
                    ->foundIn[] = $foundIn[$sku];
            }
        }
    }

    private function processPagination(
        string $html,
        string $url,
        array $config,
        int $categoryId
    ) {
        $pagination = $this->paginationCrawler
            ->maxPages($this->pageLimit)
            ->run(
                $html,
                $url,
                $config
            );

        $this->categories[$categoryId]->totalProducts =
            $pagination->totalProducts;

        $this->categories[$categoryId]->totalPages =
            $pagination->totalPages;

        $this->categories[$categoryId]->totalProductsCrawled =
            $pagination->totalProductsCrawled;

        $this->categories[$categoryId]->totalPagesCrawled =
            $pagination->totalPagesCrawled;

        $this->attachProducts(
            $pagination->products,
            $categoryId,
            $pagination->foundIn
        );

        return $pagination;
    }
}
