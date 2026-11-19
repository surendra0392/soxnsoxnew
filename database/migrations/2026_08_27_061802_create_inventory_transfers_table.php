<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->integer('source_location_id')->unsigned();
            $table->integer('destination_location_id')->unsigned();
            $table->string('status'); // requested, approved, dispatched, in_transit, received, completed, cancelled

            $table->integer('requested_by')->unsigned()->nullable();
            $table->integer('approved_by')->unsigned()->nullable();

            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('received_at')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('source_location_id')->references('id')->on('inventory_sources')->onDelete('cascade');
            $table->foreign('destination_location_id')->references('id')->on('inventory_sources')->onDelete('cascade');
            $table->foreign('requested_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transfers');
    }
};
