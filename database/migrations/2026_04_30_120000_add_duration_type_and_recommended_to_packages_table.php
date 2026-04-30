<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('duration_type', 20)->default('daily')->after('price');
            $table->unsignedInteger('duration_value')->default(30)->after('duration_type');
            $table->boolean('is_recommended')->default(false)->after('is_active');
        });

        DB::table('packages')
            ->select(['id', 'duration_days'])
            ->orderBy('id')
            ->chunkById(200, function ($packages): void {
                foreach ($packages as $package) {
                    DB::table('packages')
                        ->where('id', $package->id)
                        ->update([
                            'duration_type' => 'daily',
                            'duration_value' => max(1, (int) $package->duration_days),
                        ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['duration_type', 'duration_value', 'is_recommended']);
        });
    }
};
