<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_batches', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->unsigned();
            $table->integer('inventory_source_id')->unsigned();
            $table->string('batch_number');

            $table->decimal('qty', 12, 4)->default(0);

            $table->date('manufacturing_date')->nullable();
            $table->date('expiry_date')->nullable();

            $table->decimal('unit_cost', 12, 4)->nullable();

            $table->string('status')->default('active'); // active, expired, quarantined

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('inventory_source_id')->references('id')->on('inventory_sources')->onDelete('cascade');

            $table->unique(['product_id', 'inventory_source_id', 'batch_number'], 'prod_batch_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_batches');
    }
};
