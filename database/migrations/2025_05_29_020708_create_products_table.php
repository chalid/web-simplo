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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_category_id');
            $table->integer('brand_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('feature')->nullable();
            $table->text('specification')->nullable();
            $table->string('brochure')->nullable();
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_tag')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_author')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('meta_canonical')->nullable();
            $table->string('meta_robots')->nullable();
            $table->string('slug')->unique()->nullable(); // For SEO-friendly URLs
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};