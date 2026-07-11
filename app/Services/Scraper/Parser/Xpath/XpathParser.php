<?php

namespace App\Services\Scraper\Parser\Xpath;

use App\Services\Scraper\Parser\Exceptions\InvalidXpathException;
use DOMDocument;
use DOMXPath;
use App\Services\Scraper\Parser\Xpath\XpathResult;
use App\Services\Scraper\Parser\ParserInterface;

class XpathParser implements ParserInterface
{
    public static ?string $errors = null;
    public static function parse(string $html, string $pattern): XpathResult
    {
        if ($html === null || trim($html) === '') {
            return new XpathResult(
                new DOMDocument(),
                null,
                'HTML cannot be empty'
            );
        }

        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        if (@$xpath->query($pattern) == false) {
            self::$errors = 'Invalid xpath pattern';
        }

        $nodes = $xpath->query($pattern);

        return new XpathResult($dom, $nodes, self::$errors);
    }
}
