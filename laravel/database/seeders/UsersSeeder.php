<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::insert([
            [
              'name'=>'Admin',
              'email'=>'admin@test.com',
              'password'=>Hash::make('password')
            ],
            [
              'name'=>'Manager',
              'email'=>'manager@test.com',
              'password'=>Hash::make('password')
            ],
            [
              'name'=>'Staff 1',
              'email'=>'staff1@test.com',
              'password'=>Hash::make('password')
            ],
            [
              'name'=>'Staff 2',
              'email'=>'staff2@test.com',
              'password'=>Hash::make('password')
            ],
        ]);
    }
}
