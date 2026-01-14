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
        Schema::table('brokers', function (Blueprint $table) {
            $table->string('min_deposit')->nullable()->change();
            $table->string('years_in_business')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brokers', function (Blueprint $table) {
            $table->decimal('min_deposit', 12, 2)->nullable()->change();
            $table->integer('years_in_business')->nullable()->change();
        });
    }
};
