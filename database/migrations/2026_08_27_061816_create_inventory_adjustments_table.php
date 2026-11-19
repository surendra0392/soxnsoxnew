<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->string('type'); // stock_count, damage, expiry, loss, manual
            $table->integer('inventory_source_id')->unsigned();
            $table->string('status'); // drafted, approved, applied

            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('approved_by')->unsigned()->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('inventory_source_id')->references('id')->on('inventory_sources')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustments');
    }
};
