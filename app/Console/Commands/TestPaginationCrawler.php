<?php

namespace App\Console\Commands;

use App\Services\Scraper\Crawler\PaginationCrawler;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('app:test-pagination-crawler')]
#[Description('Command description')]
class TestPaginationCrawler extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $json = Storage::get('config/pagination.json');
        $config = json_decode($json, true);

        PaginationCrawler::run($config,);
    }
}
