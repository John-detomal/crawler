<?php

namespace App\Enums\Parser;

use App\Services\Scraper\Parser\Regex\RegexParser;
use App\Services\Scraper\Parser\Xpath\XpathParser;


enum ParserType: string
{
    case REGEX = 'regex';
    case XPATH = 'xpath';

    public function parser()
    {
        return match ($this) {
            self::REGEX => new RegexParser(),
            self::XPATH => new XpathParser(),
        };
    }
}
