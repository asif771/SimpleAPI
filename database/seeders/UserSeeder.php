<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'asif',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('asdf1234'),
            'created_at'=>now(),
        ]);
    }
}
