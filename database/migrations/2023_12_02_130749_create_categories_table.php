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
        Schema::create('categories', function (Blueprint $table) {
            // CATEGORY DATA
            $table->id();
            $table->string('name', 30)->nullable()->unique();
            $table->foreignId('parent_id')->nullable()->default(null)->constrained('categories')->nullOnDelete();

            // SEO DATA
            $table->string('slug', 50)->unique();
            $table->string('title', 50)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->text('full_description')->nullable();

            // ADVISE
            $table->string('message_type', 10)->nullable();
            $table->text('message_text')->nullable();

            // OTHERS DATA
            $table->boolean('active')->default(0);
            $table->integer('hits')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};