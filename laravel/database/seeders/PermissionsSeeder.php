<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Permission::insert([
            ['name' => 'user.manage'],

            ['name'=>'products.create'],
            ['name'=>'products.update'],
            ['name'=>'products.delete'],

            ['name'=>'category.create'],
            ['name'=>'category.update'],
            ['name'=>'category.delete'],
        ]);
    }
}
