<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $users = [
            [
                'id' => 12,
                'name' => 'سعاد',
                'email' => 'auto1@auto.local',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'worker'
            ],
            [
                'id' => 5,
                'name' => 'محمد',
                'email' => 'monsifhilali90@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'worker'
            ],
            [
                'id' => 11,
                'name' => 'حكيم',
                'email' => 'hakimrimx@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => 'CVvE7pcjy3yPFXAw6rMC7BXZEjrQeyfIwvw2Z67vixQ6yY6LurAW0ndQzUhK',
                'created_at' => null,
                'updated_at' => null,
                'role' => 'manager'
            ],
            [
                'id' => 9,
                'name' => 'وليد',
                'email' => 'walidaroudj64@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'worker'
            ],
            [
                'id' => 13,
                'name' => 'الحاج ياسين',
                'email' => 'abdallahyassine62@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'manager'
            ],
            [
                'id' => 7,
                'name' => 'عبد الرحمان',
                'email' => 'abdallhabd1500@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'manager'
            ],
            [
                'id' => 6,
                'name' => 'عدنان',
                'email' => 'adnan@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'worker'
            ],
            [
                'id' => 10,
                'name' => 'ياسين دليل',
                'email' => 'yassin@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'worker'
            ],
            [
                'id' => 8,
                'name' => 'عماد',
                'email' => 'customer_1764238454_4136@auto.local',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'customer'
            ],
            [
                'id' => 4,
                'name' => 'ياسين سالكي',
                'email' => 'ys2585561@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'worker'
            ],

        ];

        DB::table('users')->insert($users);
    }
}
