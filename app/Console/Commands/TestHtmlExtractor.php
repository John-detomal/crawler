<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\Scraper\Extractor\HtmlExtractor;
use App\Services\Scraper\Parser\Exceptions\InvalidRegexException;
use App\Services\Scraper\Utilities\Validator;

#[Signature('app:test-html-extractor')]
#[Description('Command description')]
class TestHtmlExtractor extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $json = Storage::get('config/extract.json');
        $config = json_decode($json, true);

        $html = '<ul>
                    <li>1</li>
                    <li>2</li>
                    <li>3</li>
                </ul>';

        $result = null;
        $error = null;

        try {
            $result = HtmlExtractor::extract($html, $config['container'], 'all');
        } catch (InvalidRegexException $e) {
            $error = $e;
        }


        $validation = validator::validate(
            'container',
            $config['container'],
            $result,
            $error
        );

        print_r($validation);
    }
}
