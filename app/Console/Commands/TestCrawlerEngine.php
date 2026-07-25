<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Browser\Services\Browser\BrowserService;
use App\Services\Scraper\Crawler\CrawlerEngine;

use Illuminate\Support\Facades\Storage;
use App\Services\Scraper\Crawler\Dto\CrawlJobDto;
use Illuminate\Support\Facades\Log;
use Browser\Services\FileCache\CacheService;

#[Signature('app:test-crawler-engine')]
#[Description('Command description')]
class TestCrawlerEngine extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $json = Storage::get('config/ThPetterson.json');
        $config = json_decode($json, true);

        $crawler = app(CrawlerEngine::class);

        $result = $crawler
            ->seeds([
                new CrawlJobDto(
                    url: 'https://th-pettersson.com/en/artiklar/-6/-10/index.html',
                    name: 'Home'
                )
            ])
            ->maxPages(5)
            ->limit(5)
            ->subCategories()
            ->run($config)
            ->result();

        log::info(json_encode($result, JSON_PRETTY_PRINT));
    }
}
