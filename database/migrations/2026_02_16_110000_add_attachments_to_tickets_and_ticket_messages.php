<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('attachment')->nullable()->after('description');
        });

        Schema::table('ticket_messages', function (Blueprint $table) {
            $table->string('attachment')->nullable()->after('message');
        });
    }

    public function down(): void
    {
        Schema::table('ticket_messages', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });
    }
};
