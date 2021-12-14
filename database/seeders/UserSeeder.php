<?php

namespace Database\Seeders;

use DB;
use Hash;
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
        DB::table('users')->insert([
            'name' => 'Fatimah',
            'email' => 'fatimah@gmail.com',
            'password' => Hash::make('fatimah'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
