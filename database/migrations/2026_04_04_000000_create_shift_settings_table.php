<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shift_settings', function (Blueprint $table) {
            $table->id();

            // Day shift times
            $table->time('day_start')->default('07:30'); // Default 7:30
            $table->time('day_end')->default('19:30');   // Default 19:30

            // Night shift times
            $table->time('night_start')->default('19:30'); // Default 19:30
            $table->time('night_end')->default('07:30');   // Default 7:30

            $table->timestamps();
        });

        // Insert default record
        DB::table('shift_settings')->insert([
            'day_start' => '07:30',
            'day_end' => '19:30',
            'night_start' => '19:30',
            'night_end' => '07:30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_settings');
    }
};
