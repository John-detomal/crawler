<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scraper', function (Blueprint $table) {
            $table->id('scraper_id');
            $table->string('name', 100);
            $table->string('base_url', 200);
            $table->string('browser', 15);
            $table->json('config');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraper');
    }
};
