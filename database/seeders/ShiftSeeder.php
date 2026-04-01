<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShiftSeeder extends Seeder
{
    public function run()
    {
        DB::table('shifts')->insert([
            [
                'id' => 1,
                'user_id' => 11,
                'date' => '2025-11-22',
                'time' => '14:15:44',
                'verified' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'user_id' => 5,
                'date' => '2025-11-22',
                'time' => '18:30:40',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'user_id' => 9,
                'date' => '2025-11-23',
                'time' => '17:30:10',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'user_id' => 4,
                'date' => '2025-11-23',
                'time' => '18:36:31',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'user_id' => 5,
                'date' => '2025-11-24',
                'time' => '11:46:10',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'user_id' => 9,
                'date' => '2025-11-24',
                'time' => '18:31:06',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'user_id' => 11,
                'date' => '2025-11-25',
                'time' => '06:36:24',
                'verified' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'user_id' => 4,
                'date' => '2025-11-25',
                'time' => '18:37:25',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'user_id' => 11,
                'date' => '2025-11-26',
                'time' => '06:55:28',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 10,
                'user_id' => 5,
                'date' => '2025-11-26',
                'time' => '20:29:47',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 11,
                'user_id' => 11,
                'date' => '2025-11-27',
                'time' => '06:38:48',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 12,
                'user_id' => 5,
                'date' => '2025-11-27',
                'time' => '23:07:50',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 13,
                'user_id' => 11,
                'date' => '2025-11-28',
                'time' => '06:38:40',
                'verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
