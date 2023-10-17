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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            
            $table->jsonb('title');
            $table->jsonb('slug')->unique();;
            $table->jsonb('perex');
            $table->jsonb('content');
            $table->boolean('home')->default(false);
            $table->string('template')->nullable();

            // Seo meta 
            $table->jsonb('meta_title')->nullable();
            $table->jsonb('meta_description')->nullable();
            $table->jsonb('meta_url_canolical')->nullable();
            $table->jsonb('href_lang')->nullable();
            $table->boolean('no_index')->default(false);
            $table->boolean('no_follow')->default(false);
            
            // facebook twitter meta
            $table->jsonb('og_title')->nullable();
            $table->jsonb('og_description')->nullable();
            $table->jsonb('og_type')->nullable();
            $table->jsonb('og_url')->nullable();

            $table->foreignId('user_id')->constrained('users');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
