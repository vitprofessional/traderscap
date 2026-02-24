<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the existing unique constraint
        Schema::table('user_packages', function (Blueprint $table) {
            $table->dropUnique('unique_active_package_per_user');
        });

        // Update the virtual column to include 'active_waiting'
        DB::statement("
            ALTER TABLE user_packages 
            MODIFY COLUMN active_user_check INT UNSIGNED GENERATED ALWAYS AS 
            (CASE WHEN status IN ('pending', 'active_waiting', 'active', 'expired') THEN user_id ELSE NULL END) STORED
        ");

        // Re-create the unique constraint with updated column
        Schema::table('user_packages', function (Blueprint $table) {
            $table->unique('active_user_check', 'unique_active_package_per_user');
        });
    }

    public function down(): void
    {
        // Drop the updated constraint
        Schema::table('user_packages', function (Blueprint $table) {
            $table->dropUnique('unique_active_package_per_user');
        });

        // Revert the virtual column to old definition
        DB::statement("
            ALTER TABLE user_packages 
            MODIFY COLUMN active_user_check INT UNSIGNED GENERATED ALWAYS AS 
            (CASE WHEN status IN ('pending', 'active', 'expired') THEN user_id ELSE NULL END) STORED
        ");

        // Re-create the old constraint
        Schema::table('user_packages', function (Blueprint $table) {
            $table->unique('active_user_check', 'unique_active_package_per_user');
        });
    }
};
