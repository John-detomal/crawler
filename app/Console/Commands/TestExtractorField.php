<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\Scraper\Extractor\FieldExtractor;

#[Signature('app:test-extractor-field')]
#[Description('Command description')]
class TestExtractorField extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $json = Storage::get('config/field.json');
        $config = json_decode($json, true);

        $html = '<a href="test">test</a>';

        $result = FieldExtractor::extract($html, $config['fields']['url'], $config['patterns']);

        dd($result);
    }
}
