<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('package_id')
                ->constrained('packages')
                ->onDelete('cascade');

            // tanggal booking
            $table->date('booking_date');

            // jam booking
            $table->time('start_time');
            $table->time('end_time');
            // lokasi pemotretan
            $table->string('location')->nullable();

            // catatan customer
            $table->text('notes')->nullable();

            // snapshot harga
            $table->integer('total_price');

            // $table->string('phone')->nullable();

            $table->enum('status', [
                'pending',
                'confirmed',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('phone');
        });
    }

    
};