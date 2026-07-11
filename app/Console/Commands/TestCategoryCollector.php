<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Browser\Services\Browser\BrowserService;
use App\Services\Scraper\Collectors\Category\CategoryCollector;
use Illuminate\Support\Facades\Storage;

#[Signature('app:test-category-collector')]
#[Description('Command description')]
class TestCategoryCollector extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $options = [
            'settings' => [
                'browser' => 'curl',
            ],
            'cache_options' => [
                'is_cache' => true,
            ]
        ];

        $json = Storage::get('config/Category.json');
        $config = json_decode($json, true);

        $browser = new BrowserService($options);

        $html = $browser->openPage('https://th-pettersson.com/en/artiklar/-6/index.html')['content'];

        // $config = $request->all();
        $response = CategoryCollector::collect($html, $config, 'https://th-pettersson.com');

        print_r($response);
    }
}
