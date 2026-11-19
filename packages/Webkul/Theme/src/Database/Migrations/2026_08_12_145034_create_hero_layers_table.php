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
        Schema::create('theme_hero_layers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hero_slide_id')->unsigned();

            $table->string('type')->default('text'); // text, heading, button, image
            $table->string('name')->nullable();
            $table->integer('sort_order')->default(0);

            $table->text('content')->nullable(); // Can be text, HTML, or image path

            // Positioning, size, typography
            $table->json('desktop_settings')->nullable();
            $table->json('tablet_settings')->nullable();
            $table->json('mobile_settings')->nullable();
            $table->json('settings')->nullable(); // Global settings (e.g. text color, button style, link target)

            $table->timestamps();

            $table->foreign('hero_slide_id')->references('id')->on('theme_hero_slides')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_hero_layers');
    }
};
