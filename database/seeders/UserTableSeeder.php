<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Muhammad Rizky Firdaus', 
            'email'     => 'rizky@gmail.com',
            'password'  => Hash::make('12345678'),
            'age'       => 23
        ]);
    }
}
