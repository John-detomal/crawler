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

        Schema::create('scraper_runs', function (Blueprint $table) {
            $table->id('scraper_log_id');
            $table->unsignedBigInteger('scraper_id')->nullable();
            $table->unsignedBigInteger('queued_by')->nullable();

            $table->integer('status')->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraper_runs');
    }
};
