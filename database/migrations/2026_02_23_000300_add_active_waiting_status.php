<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update user_packages table status enum
        DB::statement("ALTER TABLE `user_packages` MODIFY `status` ENUM('registered','pending','active_waiting','active','expired','cancelled') NOT NULL DEFAULT 'registered'");
    }

    public function down(): void
    {
        // Revert back to previous enum
        DB::statement("ALTER TABLE `user_packages` MODIFY `status` ENUM('registered','pending','active','expired','cancelled') NOT NULL DEFAULT 'registered'");
    }
};
