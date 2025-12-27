<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = Role::where('name', 'admin')->first();
        $manager = Role::where('name', 'manager')->first();
        $staff = Role::where('name', 'staff')->first();

        $admin->permissions()->sync(Permission::all());

        $manager->permissions()->sync(Permission::whereIn('name', [
            'products.create',
            'products.update',
            'category.create',
            'category.update'
        ])->pluck('id'));

        $staff->permissions()->sync(Permission::whereIn('name', [
            'products.create',
            'products.update'
        ])->pluck('id'));
    }
}
