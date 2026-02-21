<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('admins', 'avatar')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('avatar')->nullable()->after('is_active');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('admins', 'avatar')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('avatar');
            });
        }
    }
};