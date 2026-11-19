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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->unsigned();
            $table->integer('inventory_source_id')->unsigned();
            $table->decimal('quantity', 12, 4); // Signed decimal to support UOM fractions and negative movements

            $table->string('type'); // receipt, issue, adjustment, transfer_in, transfer_out, customer_return, opening

            $table->string('reference_type')->nullable(); // e.g. Shipment, Refund, Adjustment, Transfer
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->string('batch_number')->nullable();
            $table->string('serial_number')->nullable();

            $table->decimal('unit_cost', 12, 4)->nullable();

            $table->integer('user_id')->unsigned()->nullable(); // Admin user who caused the movement

            $table->string('reason')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('inventory_source_id')->references('id')->on('inventory_sources')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
