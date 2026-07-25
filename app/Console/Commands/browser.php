<?php

namespace App\Console\Commands;

use App\Services\Scraper\Collectors\SubCategory\SubCategoryCollector;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use Browser\Services\Browser\BrowserService;
use Browser\Services\Browser\Middleware\Factory\PipelineFactory;
use Browser\Services\Browser\Middleware\Registry\MiddlewareRegistry;
use Browser\Services\Browser\Pipeline\BrowserPipeline;
use Illuminate\Support\Facades\Storage;

#[Signature('app:browser')]
#[Description('Command description')]
class browser extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {

        echo "Start";
        $json = Storage::get('config/ThPetterson.json');
        $config = json_decode($json, true);
        $baseUrl = $config['settings']['base_url'];

        $options = [
            'settings' => [
                'browser' => 'curl'
            ]
        ];

        $proxies = [
            [
                'ip' => '192.168.1.10',
                'port' => '1080',
            ],
            [
                'ip' => '192.168.1.11',
                'port' => '1080',
            ],
            [
                'ip' => '192.168.1.12',
                'port' => '1080',
            ],
        ];

        $factory = new PipelineFactory();
        $pipeline = new BrowserPipeline(MiddlewareRegistry::register($factory));
        $browser = new BrowserService($pipeline);

        $urls = [

            "https://example.com",

            // "https://httpbin.org/user-agent",
            // "https://httpbin.org/redirect/3",
            // "https://webscraper.io/test-sites/e-commerce/allinone",
        ];


        foreach ($urls as $url) {
            $browser->openPage($url);
            $response = $browser->response()->html;

            echo $response;
        }
    }
}
