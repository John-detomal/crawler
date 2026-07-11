<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ScraperModel extends Model
{
    //
    protected $table = 'scraper';
    protected $primaryKey = 'scraper_id';
    protected $timeStamps = true;

    protected $casts = [
        'config' => 'array'
    ];

    protected $fillable = [
        'name',
        'base_url',
        'browser',
        'config',
    ];
}
