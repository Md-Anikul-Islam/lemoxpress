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
        Schema::create('trip_requests', function (Blueprint $table) {
            $table->id();
            $table->string('driver_id');
            $table->string('passenger_name');
            $table->string('passenger_phone');
            $table->string('origin_address');
            $table->string('destination_address');
            $table->string('time');
            $table->string('estimated_fare');
            $table->string('calculated_fare');
            $table->string('fare_received_status')->nullable(); //1=estimated_fare,2=calculated_fare
            $table->string('is_complete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_requests');
    }
};
