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
        Schema::create('driver_histories', function (Blueprint $table) {
            $table->id();
            $table->string('did');
            $table->string('origin_address');
            $table->string('destination_address');
            $table->string('time');
            $table->float('total_fare');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_histories');
    }
};
