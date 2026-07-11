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
        Schema::create('scraper_edges', function (Blueprint $table) {
            $table->id('scraper_edges_id');

            $table->unsignedBigInteger('scraper_run_id')->index();

            $table->unsignedBigInteger('parent_page_id')->index()->nullable();

            $table->integer('relation_type')->index();
            // category_to_subcategory, subcategory_to_item, etc

            // 🔥 prevents duplicate relationships
            $table->unique(['parent_page_id', 'child_page_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraper_edges');
    }
};
