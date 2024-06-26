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
        Schema::create('user_histories', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->integer('user_id')->nullable();
            $table->integer('did')->nullable();
            $table->string('origin_address');
            $table->string('destination_address');
            $table->string('time');
            $table->float('total_fare');
            $table->string('trip_type')->default('request_trip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_histories');
    }
};
