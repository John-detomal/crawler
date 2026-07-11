<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Scraper\ScraperController;


Route::inertia('/', 'welcome')->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
Route::inertia('dashboard', 'dashboard')->name('dashboard');
// });

// Route::inertia('admin', 'admin/index');
// Route::inertia('scraper', 'admin/scraper/index')->name('scraper');


Route::prefix('scraper')
    ->name('scraper.')
    ->controller(ScraperController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');

        Route::prefix('scrape')
            ->name('scrape.')
            ->group(function () {
                Route::post('/category', 'category')->name('category');
            });
    });

require __DIR__ . '/settings.php';
