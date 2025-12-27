<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::where('email', 'admin@test.com')->first()->roles()->sync(Role::where('name', 'admin')->first());
        User::where('email', 'manager@test.com')->first()->roles()->sync(Role::where('name', 'manager')->first());
        User::where('email', 'staff1@test.com')->first()->roles()->sync(Role::where('name', 'staff')->first());
        User::where('email', 'staff2@test.com')->first()->roles()->sync(Role::where('name', 'staff')->first());
    }
}
