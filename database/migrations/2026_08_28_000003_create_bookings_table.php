<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->date('check_in');
            $table->time('check_in_time')->default('14:00');
            $table->date('check_out');
            $table->time('check_out_time')->default('12:00');
            $table->integer('total_nights');
            $table->integer('late_hours')->default(0);
            $table->integer('late_fee')->default(0);
            $table->integer('total_price');
            $table->string('payment_method')->default('qris'); // 'qris' atau 'cash'
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
