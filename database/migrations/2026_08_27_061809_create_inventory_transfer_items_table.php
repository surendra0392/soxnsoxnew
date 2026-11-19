<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_transfer_id')->constrained('inventory_transfers')->onDelete('cascade');
            $table->integer('product_id')->unsigned();

            $table->decimal('qty_requested', 12, 4)->default(0);
            $table->decimal('qty_dispatched', 12, 4)->default(0);
            $table->decimal('qty_received', 12, 4)->default(0);

            $table->string('batch_number')->nullable();

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transfer_items');
    }
};
