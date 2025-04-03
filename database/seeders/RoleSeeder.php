<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        //
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'opd']);
        Role::create(['name' => 'doctor']);
        Role::create(['name' => 'patient']);
    }
}
