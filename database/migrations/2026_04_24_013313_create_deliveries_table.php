<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            $table->string('delivery_link')->nullable();

            $table->string('delivery_file')->nullable();

            $table->dateTime('delivery_date')->nullable();

            $table->enum('status', [
                'editing',
                'delivered',
                'revision',
                'completed'
            ])->default('editing');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};