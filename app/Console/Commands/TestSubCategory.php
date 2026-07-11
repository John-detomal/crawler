<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Services\Scraper\Collectors\SubCategory\SubCategoryCollector;
use Browser\Services\Browser\BrowserService;
use Illuminate\Support\Facades\Storage;

#[Signature('app:test-sub-category')]
#[Description('Command description')]
class TestSubCategory extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {

        $json = Storage::get('config/ThPetterson.json');
        $config = json_decode($json, true);
        $baseUrl = $config['settings']['base_url'];

        $options = [
            'settings' => [
                'browser' => 'curl'
            ]
        ];

        $browser = new BrowserService($options);

        // $html = $browser->openPage($baseUrl)['content'];
        // $categories = CategoryCollector::collect($html, $config['category'], $baseUrl);

        // $categoryResponse = $categories->where('category_name', 'TIRES')->values()->all();

        // foreach ($categoryResponse as $category) {
        $html = $browser->openPage('https://th-pettersson.com/en/artiklar/-6/index.html')['content'];
        $result = SubCategoryCollector::collect($html, $config['sub_category'], $baseUrl);

        // }

        print_r($result);
        // $blockResult = HtmlExtractor::extract($html, $category['category']);

        // dd($blockResult);
    }
}
