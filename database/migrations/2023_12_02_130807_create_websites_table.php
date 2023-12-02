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
        Schema::create('websites', function (Blueprint $table) {
            // WEBSITE DATA
            $table->id();
            $table->string('name', 30)->nullable();

            // URLS
            $table->string('display_url', 255)->unique();
            $table->string('sponsored_url', 255)->unique()->nullable();

            // SEO DATA
            $table->string('slug', 50)->unique();
            $table->string('title', 50)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->text('full_description')->nullable();

            // OTHERS DATA
            $table->boolean('active')->default(0);
            $table->integer('hits')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_website', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('website_id')->constrained()->onDelete('cascade');

            $table->unique(['category_id', 'website_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};