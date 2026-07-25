<?php

namespace App\Services\Scraper\Crawler;

use App\Enums\Parser\ParserType;
use Browser\Services\Browser\BrowserService;

use App\Services\Scraper\Extractor\PaginationExtractor;
use App\Services\Scraper\Crawler\Dto\PaginationDto;
use App\Services\Scraper\Collectors\Items\ItemsCollector;
use RuntimeException;
use App\Services\Scraper\Crawler\Crawler;

class PaginationCrawler
{
    use Crawler;

    public function __construct(
        private BrowserService $browser,
    ) {}

    public function run(
        string $html,
        string $url,
        array $config,

    ): PaginationDto {

        $paginationConfig = $config['pagination'];
        $fields = $paginationConfig['options']['fields'];

        $incrementField = $this->findIncrementingField(
            $fields
        );

        $offset = $fields[$incrementField]['value'];
        $step = $offset;

        $totalProducts = $this->extractTotalProducts(
            $html,
            $paginationConfig['limit']
        );

        $perPage = $fields['limits']['value'];

        $totalPages = max(
            1,
            (int) ceil($totalProducts / $perPage)
        );

        $products = [];
        $foundIn = [];

        $paginationUrl = '';

        $itemsCount = $this->processItemsFound(
            $html,
            $config['items'],
            $url,
            $products,
            $foundIn,
            1,
        );

        $page = 2;
        while (true) {

            $config['pagination']['options']['fields']['offset']['value'] = $offset;
            $paginationUrl = PaginationExtractor::extract(
                $html ?? '',
                $config['pagination']
            );

            $response = $this->browser
                ->openPage("https://th-pettersson.com/?$paginationUrl");

            $pageHtml = $response->response()->html;
            $message = $response->response()->responseMessage;

            $offset += $step;
            $itemsCount += $this->processItemsFound(
                $pageHtml,
                $config['items'],
                $paginationUrl,
                $products,
                $foundIn,
                $page,
            );

            if ($this->shouldStop($page, $totalPages, $itemsCount, $message)) {
                break;
            }

            $page++;
        }

        return new PaginationDto(
            totalProducts: $totalProducts,
            totalPages: $totalPages,
            products: $products,
            foundIn: $foundIn,
            totalPagesCrawled: $page ?? 1,
            totalProductsCrawled: $itemsCount
        );
    }

    private function extractTotalProducts(
        string $html,
        array $config
    ): int {
        $parser = ParserType::from($config['type'])->parser();

        return (int)$parser->parse($html, $config['pattern'])->item(0)->text(1);
    }

    private function findIncrementingField(
        array $fields
    ): string {

        foreach ($fields as $key => $field) {

            if (
                isset($field['increment']) &&
                $field['increment']
            ) {
                return $key;
            }
        }

        throw new RuntimeException(
            'Increment field not found.'
        );
    }

    private function processItemsFound(
        string $html,
        array $config,
        string $url,
        array &$products,
        array &$foundIn,
        int $page
    ): int {
        $items = ItemsCollector::collect(
            $html,
            $config,
            'https://th-pettersson.com'
        );

        foreach ($items as $item) {
            $products[] = $item;

            $foundIn[$item['sku']] = [
                'page' => $page,
                'url' => $url,
            ];
        }

        return count($items);
    }

    private function shouldStop(
        int $page,
        int $totalPages,
        int $itemsCount,
        string $message
    ): bool {
        return ($this->pageLimit && $page >= $this->pageLimit)
            || $page >= $totalPages
            || $itemsCount === 0
            || $message !== 'success';
    }
}
