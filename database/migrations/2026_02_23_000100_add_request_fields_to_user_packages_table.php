<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_packages', function (Blueprint $table) {
            $table->string('broker_name')->nullable()->after('package_id');
            $table->string('trading_id')->nullable()->after('broker_name');
            $table->string('trading_password')->nullable()->after('trading_id');
            $table->string('trading_server')->nullable()->after('trading_password');
            $table->decimal('equity', 12, 2)->nullable()->after('trading_server');
        });
    }

    public function down(): void
    {
        Schema::table('user_packages', function (Blueprint $table) {
            $table->dropColumn([
                'broker_name',
                'trading_id',
                'trading_password',
                'trading_server',
                'equity',
            ]);
        });
    }
};
