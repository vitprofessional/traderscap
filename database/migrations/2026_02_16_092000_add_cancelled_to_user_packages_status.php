<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add 'cancelled' to the enum values for status
        DB::statement("ALTER TABLE `user_packages` MODIFY `status` ENUM('registered','pending','active','expired','cancelled') NOT NULL DEFAULT 'registered'");
    }

    public function down()
    {
        // Revert to previous set (drops 'cancelled')
        DB::statement("ALTER TABLE `user_packages` MODIFY `status` ENUM('registered','pending','active','expired') NOT NULL DEFAULT 'registered'");
    }
};
