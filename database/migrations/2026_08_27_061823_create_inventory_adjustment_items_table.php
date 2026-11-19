<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_adjustment_id')->constrained('inventory_adjustments')->onDelete('cascade');
            $table->integer('product_id')->unsigned();

            $table->decimal('system_qty', 12, 4)->default(0);
            $table->decimal('actual_qty', 12, 4)->default(0);
            $table->decimal('adjusted_qty', 12, 4)->default(0); // actual - system

            $table->string('batch_number')->nullable();

            $table->string('reason')->nullable();

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustment_items');
    }
};
