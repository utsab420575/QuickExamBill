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
        Schema::create('contributors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation');
            $table->string('photo')->nullable();   // store relative path (e.g. images/contributors/xxx.jpg)
            $table->string('profile')->nullable(); // external URL (github/linkedin/etc.)
            $table->text('speech')->nullable();    // short note/quote
            $table->unsignedBigInteger('user_id'); // FK to users

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade'); // if the user is removed, their contributor row goes too
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributors');
    }
};
