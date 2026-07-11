<?php

namespace App\Services\Scraper\Utilities;

use App\Services\Scraper\Extractor\HtmlExtractor;

class Utils
{
    public static function fixUrl(string $url, string $baseLink): string
    {
        $url = str_replace('\/', '/', trim($url));

        if (parse_url(trim($url), PHP_URL_SCHEME)) {
            return $url;
        }

        $base = parse_url($baseLink);
        $scheme = $base['scheme'] ?? 'https';
        $host   = $base['host'] ?? '';
        $basePath = $base['path'] ?? '/';

        if (!$host) {
            return $url;
        }

        if (str_starts_with($url, '//')) {
            return "{$scheme}:{$url}";
        }

        if (str_starts_with($url, '/')) {
            return "{$scheme}://{$host}{$url}";
        }

        if (!str_ends_with($basePath, '/')) {
            $basePath = dirname($basePath) . '/';
        }

        return "{$scheme}://{$host}{$basePath}{$url}";
    }

    public static function parseHtmlPage(string $page, int $depth = 0): string
    {
        if (empty($page)) {
            return '';
        }

        if ($depth > 3) {
            return $page;
        }

        $encodings = ['UTF-8', 'Windows-1252', 'ISO-8859-1'];

        $encoding = mb_detect_encoding($page, $encodings, true) ?: 'UTF-8';
        if ($encoding !== 'UTF-8') {
            $page = mb_convert_encoding($page, 'UTF-8', $encoding);
        }

        $chunkSize = 10000;
        $decodedPage = '';

        $length = mb_strlen($page, 'UTF-8');
        for ($i = 0; $i < $length; $i += $chunkSize) {
            $chunk = mb_substr($page, $i, $chunkSize, 'UTF-8');
            $decodedPage .= html_entity_decode($chunk, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        if ($decodedPage === $page) {
            return $decodedPage;
        }

        if (self::is_fully_decoded($decodedPage)) {
            return $decodedPage;
        }

        return self::parseHtmlPage($decodedPage, $depth + 1);
    }

    public static function extractContainerWithItemsConfig(
        array $config,
        string $html
    ): array {
        $htmls = [];

        if (isset($config['container'])) {
            $container = HtmlExtractor::extract($html, $config['container']);

            // update the value of html
            $html = $container;
        }

        $items = HtmlExtractor::extract($html, $config['items'], 'all');
        $htmls = $items;

        return $htmls;
    }

    private function is_fully_decoded(string $string): bool
    {
        return preg_match('/&[a-zA-Z]+;|&#[0-9]+;|&#x[0-9a-fA-F]+;/', $string) === 0;
    }
}
