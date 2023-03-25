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
        Schema::create('deals', function (Blueprint $table) {
            $table->string('internal_name');
            $table->string('title');
            $table->string('metacritic_link')->nullable();
            $table->string('deal_id')->primary();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('game_id');
            $table->decimal('sale_price', 10, 2);
            $table->decimal('normal_price', 10, 2);
            $table->boolean('is_on_sale');
            $table->decimal('savings', 10, 6);
            $table->integer('metacritic_score')->default(0);
            $table->string('steam_rating_text')->nullable();
            $table->integer('steam_rating_percent')->default(0);
            $table->integer('steam_rating_count')->default(0);
            $table->unsignedBigInteger('steam_app_id')->nullable();
            $table->integer('release_date');
            $table->integer('last_change');
            $table->decimal('deal_rating', 3, 1)->nullable();
            $table->string('thumb')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
