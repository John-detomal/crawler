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

        $options = [
            'settings' => [
                'browser' => 'curl',
                'debugging' => false,
            ],
            'cache_options' => [
                'is_cache' => true,
            ]
        ];

        $browser = new BrowserService($options);
        $crawler = new CrawlerEngine($browser);

        $result = $crawler
            ->seeds([
                new CrawlJobDto(
                    url: 'https://th-pettersson.com/en/artiklar/-6/index.html',
                    name: 'Tires',
                ),
            ])
            ->maxPages(5)
            ->run($config)
            ->result();

        log::info(json_encode($result, JSON_PRETTY_PRINT));
    }
}
