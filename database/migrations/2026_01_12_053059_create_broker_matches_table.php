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
        Schema::create('broker_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broker_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quiz_answer_id')->constrained()->cascadeOnDelete();
            $table->integer('weight')->default(1);
            $table->timestamps();
            $table->unique(['broker_id', 'quiz_answer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broker_matches');
    }
};
