<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Clean up any duplicate pending/active_waiting/active/expired records first (keep latest)
        DB::statement("
            DELETE up1 FROM user_packages up1
            INNER JOIN user_packages up2 
            WHERE up1.user_id = up2.user_id
            AND up1.id < up2.id
            AND up1.status IN ('pending', 'active_waiting', 'active', 'expired')
            AND up2.status IN ('pending', 'active_waiting', 'active', 'expired')
        ");

        // For MySQL: Create unique index on user_id where status is pending/active_waiting/active/expired
        // Note: MySQL doesn't support partial unique indexes natively, so we use a workaround
        // by creating a generated virtual column and applying unique constraint
        
        Schema::table('user_packages', function (Blueprint $table) {
            // Add a virtual column that's NULL for cancelled/registered and user_id otherwise
            DB::statement("
                ALTER TABLE user_packages 
                ADD COLUMN active_user_check INT UNSIGNED GENERATED ALWAYS AS 
                (CASE WHEN status IN ('pending', 'active_waiting', 'active', 'expired') THEN user_id ELSE NULL END) STORED
            ");
        });

        // Add unique constraint on the virtual column (NULLs are ignored in unique constraints)
        Schema::table('user_packages', function (Blueprint $table) {
            $table->unique('active_user_check', 'unique_active_package_per_user');
        });
    }

    public function down(): void
    {
        Schema::table('user_packages', function (Blueprint $table) {
            $table->dropUnique('unique_active_package_per_user');
        });

        DB::statement("ALTER TABLE user_packages DROP COLUMN active_user_check");
    }
};
