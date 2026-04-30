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
        Schema::create('brokers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->decimal('min_deposit', 12, 2)->nullable();
            $table->string('regulation')->nullable();
            $table->integer('years_in_business')->nullable();
            $table->json('features')->nullable();
            $table->json('pros')->nullable();
            $table->json('cons')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brokers');
    }
};
