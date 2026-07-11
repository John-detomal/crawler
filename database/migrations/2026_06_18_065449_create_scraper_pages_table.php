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
        Schema::create('scraper_pages', function (Blueprint $table) {
            $table->id('scraper_pages_id');

            $table->unsignedBigInteger('scraper_run_id')->index();

            $table->text('url'); // store full 500+ length safely
            $table->char('url_hash', 32)->unique(); // md5

            $table->integer('type')->index();
            // category | subcategory | item | page

            $table->integer('status')->index();
            // pending | processing | done | error

            $table->integer('status_code')->nullable();

            $table->text('error_message')->nullable();
            $table->timestamps();

            // 🔥 IMPORTANT INDEXES

            $table->index(['scraper_run_id', 'status']); // fast queue fetch

            $table->index(['type', 'status']); // filter by stage

            $table->index('created_at'); // analytics / ordering
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraper_pages');
    }
};
