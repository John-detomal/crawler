<?php

namespace App\Services\Scraper\Parser;

use App\Services\Scraper\Parser\Regex\RegexResult;
use App\Services\Scraper\Parser\Xpath\XpathResult;

interface ParserInterface
{
    public static function parse(string $html, string $pattern): RegexResult | XpathResult;
}
