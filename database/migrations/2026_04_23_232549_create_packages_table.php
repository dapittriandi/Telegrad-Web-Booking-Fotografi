<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->string('name');

            $table->integer('price');

            // dalam menit
            $table->integer('duration')->nullable();
            $table->string('participants');

            $table->integer('min_participants')->nullable();
            $table->integer('max_participants')->nullable();

            $table->boolean('unlimited_participants')->default(false);

            $table->text('features')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};