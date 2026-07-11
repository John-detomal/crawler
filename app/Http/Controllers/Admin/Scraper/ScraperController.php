<?php

namespace App\Http\Controllers\Admin\Scraper;

use App\Http\Controllers\Controller;
use App\Http\Requests\Scraper\ScraperRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\Scraper\Extractor\HtmlExtractor;
use App\Services\Scraper\Collectors\Category\CategoryCollector;
use Browser\Services\Browser\BrowserService;
use App\Models\Admin\ScraperModel;

class ScraperController extends Controller
{
    //
    public function index()
    {
        return inertia::render('admin/scraper/index');
    }

    public function store(ScraperRequest $request)
    {
        ScraperModel::create([
            'name' => $request->input('name'),
            'base_url' => $request->input('settings.base_url'),
            'browser' => $request->input('settings.browser'),
            'config' => $request->input('config')
        ]);

        return response()->json([
            'message' => 'stored'
        ]);
    }

    public function category(ScraperRequest $request)
    {

        $options = [
            'settings' => [
                'browser' => 'curl'
            ],
            'cache_options' => [
                'is_cache' => true,
            ]
        ];

        $browser = new BrowserService($options);

        $html = $browser->openPage('https://th-pettersson.com/en/artiklar/-6/index.html')['content'];

        $config = $request->all();
        $response = CategoryCollector::collect($html, $config, 'https://th-pettersson.com');

        return response()->json($response);
    }
}
