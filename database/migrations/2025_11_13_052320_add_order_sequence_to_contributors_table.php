<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contributors', function (Blueprint $table) {
            // small unsigned ints with default 0; adjust if you prefer nullable()
            $table->unsignedSmallInteger('order')->default(10000)->after('speech');
            $table->unsignedSmallInteger('sequence')->default(10000)->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('contributors', function (Blueprint $table) {
            $table->dropColumn(['order', 'sequence']);
        });
    }
};
