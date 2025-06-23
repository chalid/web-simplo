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
        Schema::create('ex_vessel_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ex_vessel_id');
            $table->string('uri');
            $table->boolean('is_default')->default(0);
            $table->timestamps();

            $table->foreign('ex_vessel_id')->references('id')->on('ex_vessels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ex_vessel_images');
    }
};
