<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => "admin",
            'email' => "admin999".'@gmail.com',
            'password' => \Hash::make('12345678'),
            'role' => 'admin',
        ]);
        \DB::table('users')->insert([
            'name' => "user",
            'email' => "user".'@gmail.com',
            'password' => \Hash::make('12345678'),
        ]);
    }
}
