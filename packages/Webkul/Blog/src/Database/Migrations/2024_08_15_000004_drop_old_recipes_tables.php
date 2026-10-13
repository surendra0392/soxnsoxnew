<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('recipe_products');
        Schema::dropIfExists('recipe_translations');
        Schema::dropIfExists('recipes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
};
