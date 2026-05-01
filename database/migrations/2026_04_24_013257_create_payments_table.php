<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            $table->integer('amount');

            $table->string('payment_method');

            $table->string('payment_proof')->nullable();

            $table->enum('payment_status', [
                'pending',
                'verified',
                'rejected'
            ])->default('pending');

            $table->dateTime('payment_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};