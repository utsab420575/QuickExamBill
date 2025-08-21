<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name');        // Full name
            $table->string('short_name')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
        });

        // Predefined universities in Bangladesh
        DB::table('universities')->insert([
            ['name' => 'University of Dhaka', 'short_name' => 'DU', 'city' => 'Dhaka', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bangladesh University of Engineering and Technology', 'short_name' => 'BUET', 'city' => 'Dhaka', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Khulna University of Engineering & Technology', 'short_name' => 'KUET', 'city' => 'Khulna', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chittagong University of Engineering & Technology', 'short_name' => 'CUET', 'city' => 'Chattogram', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rajshahi University of Engineering & Technology', 'short_name' => 'RUET', 'city' => 'Rajshahi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dhaka University of Engineering & Technology', 'short_name' => 'DUET', 'city' => 'Gazipur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jahangirnagar University', 'short_name' => 'JU', 'city' => 'Savar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'University of Rajshahi', 'short_name' => 'RU', 'city' => 'Rajshahi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'University of Chittagong', 'short_name' => 'CU', 'city' => 'Chattogram', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Khulna University', 'short_name' => 'KU', 'city' => 'Khulna', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Shahjalal University of Science and Technology', 'short_name' => 'SUST', 'city' => 'Sylhet', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Noakhali Science and Technology University', 'short_name' => 'NSTU', 'city' => 'Noakhali', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jagannath University', 'short_name' => 'JnU', 'city' => 'Dhaka', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'National University', 'short_name' => 'NU', 'city' => 'Gazipur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bangladesh Agricultural University', 'short_name' => 'BAU', 'city' => 'Mymensingh', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sher-e-Bangla Agricultural University', 'short_name' => 'SAU', 'city' => 'Dhaka', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bangladesh University of Professionals', 'short_name' => 'BUP', 'city' => 'Dhaka', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bangabandhu Sheikh Mujib Medical University', 'short_name' => 'BSMMU', 'city' => 'Dhaka', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hajee Mohammad Danesh Science and Technology University', 'short_name' => 'HSTU', 'city' => 'Dinajpur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Patuakhali Science and Technology University', 'short_name' => 'PSTU', 'city' => 'Patuakhali', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mawlana Bhashani Science and Technology University', 'short_name' => 'MBSTU', 'city' => 'Tangail', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Comilla University', 'short_name' => 'CoU', 'city' => 'Cumilla', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Begum Rokeya University', 'short_name' => 'BRUR', 'city' => 'Rangpur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'University of Barishal', 'short_name' => 'BU', 'city' => 'Barishal', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
