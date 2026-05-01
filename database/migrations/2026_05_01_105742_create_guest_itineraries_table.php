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
        Schema::create('guest_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['ARRIVAL', 'DEPARTURE', 'AGENDA']);
            $table->string('flight_no', 20)->nullable();
            $table->string('pnr_code', 20)->nullable();
            $table->dateTime('schedule_time');
            $table->string('airport_or_location', 150)->nullable();
            $table->string('hotel_name', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_itineraries');
    }
};
