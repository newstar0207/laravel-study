<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = Str::random(5);

        DB::table('users')->insert([
            'email' => $name . '@gmail.com',
            'name' => $name,
            'password' => Hash::make('testtest'),
        ]);
    }
}
