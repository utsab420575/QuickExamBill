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
        Schema::table('teachers', function (Blueprint $table) {
            // Place near other FKs for readability; nullable so existing rows don’t break
            $table->foreignId('university_id')
                ->nullable()
                ->after('department_id')
                ->constrained('universities')
                ->nullOnDelete(); // If a university is deleted, set to NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Drop FK then column
            $table->dropConstrainedForeignId('university_id');
        });

    }
};
