<?php

namespace App\Services\Scraper\Utilities;

use Exception;
use Throwable;

class Validator
{
    /**
     * @phpstan-type ConfigNode array{
     *     type: string,
     *     pattern: string,
     *     is_match_required?: bool
     * }
     *
     * @param ConfigNode|array<string, ConfigNode> $config
     */
    public static function validate(
        string $key,
        array $config,
        mixed $matches,
        Throwable | null $error,
    ) {

        $result = is_array($matches) ? $matches[0] : $matches;

        $response = [
            "sucess" => true,
            "field" => $key,
            "config" => $config,
            "content" => substr($result, 0, 120),
        ];

        if (!$matches) {
            return [
                "sucess" => false,
                "field" => $key,
                "code" =>  $error ? "invalid" : "no_matches",
                "config" => $config
            ];
        }

        return $response;
    }
}
