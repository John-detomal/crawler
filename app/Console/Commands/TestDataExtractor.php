<?php

namespace App\Console\Commands;

use App\Services\Scraper\Extractor\DataExtractor;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('app:test-data-extractor')]
#[Description('Command description')]
class TestDataExtractor extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $json = Storage::get('config/field.json');
        $config = json_decode($json, true);

        $htmls = [
            '<a href="test">test</a>'
        ];

        $result = DataExtractor::extract($htmls, $config['options'], "https://th-pettersson.com/");

        dd($result);
    }
}
