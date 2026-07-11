<?php

namespace App\Services\Scraper\Parser\Regex;

use App\Services\Scraper\Parser\Exceptions\InvalidRegexException;
use App\Services\Scraper\Parser\ParserInterface;
use App\Services\Scraper\Parser\Regex\RegexResult;
use App\Services\Scraper\Traces\Parser\ParserTrace;

class RegexParser implements ParserInterface
{
    public static ParserTrace $traces;
    public static function parse(string $html, string $pattern): RegexResult
    {
        if (@preg_match($pattern, '') === false) {
            throw new InvalidRegexException('Invalid regex pattern');
        }

        preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);

        // self::traces($matches, $pattern, $start);

        return new RegexResult($matches ?? []);
    }

    // private static function traces(array $matches, string $pattern, float $start)
    // {
    //     $duration = microtime(true) - $start;

    //     self::$traces =  new ParserTrace(
    //         type: 'regex',
    //         pattern: $pattern,
    //         count: count($matches),
    //         duration: $duration,
    //         content: substr($matches[0][0] ?? '', 0, 120)
    //     );
    // }
}
