<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\Scraper\Extractor\FieldExtractor;
use App\Services\Scraper\Extractor\PaginationExtractor;

#[Signature('app:test-pagination-extractor')]
#[Description('Command description')]
class TestPaginationExtractor extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $json = Storage::get('config/pagination.json');
        $config = json_decode($json, true);

        $html = '<a href="test">test</a>';

        $result = PaginationExtractor::extract($html, $config);

        dd($result);
    }
}
