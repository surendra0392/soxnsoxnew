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
        Schema::create('theme_hero_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hero_slider_id')->unsigned();
            $table->string('name')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('sort_order')->default(0);

            $table->string('media_type')->default('image'); // image, video
            $table->string('desktop_media')->nullable();
            $table->string('mobile_media')->nullable();
            $table->string('poster_media')->nullable();
            $table->string('video_url')->nullable();

            $table->integer('duration')->default(5000);
            $table->string('transition')->default('fade'); // fade, slide

            $table->dateTime('active_from')->nullable();
            $table->dateTime('active_to')->nullable();

            $table->json('settings')->nullable();
            $table->timestamps();

            $table->foreign('hero_slider_id')->references('id')->on('theme_hero_sliders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_hero_slides');
    }
};
