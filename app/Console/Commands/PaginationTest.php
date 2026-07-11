<?php

namespace App\Console\Commands;

use App\Services\Scraper\Crawler\PaginationCrawler;
use App\Services\Scraper\Extractor\PaginationExtractor;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Services\Scraper\Extractor\QueryParamsExtractor;
use Browser\Services\Browser\BrowserService;
use Illuminate\Support\Facades\Storage;

#[Signature('app:pagination-test')]
#[Description('Command description')]
class PaginationTest extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $json = Storage::get('config/ThPetterson.json');
        $config = json_decode($json, true);

        $options = [
            'settings' => [
                'browser' => 'curl'
            ]
        ];

        $browser = new BrowserService($options);


        $paginationCrawler = new PaginationCrawler($browser);
        $paginationCrawler->run($config);
        // $result = PaginationExtractor::extract('test', $config['pagination']);
        // dd($result);

        // echo $result;
    }
}
