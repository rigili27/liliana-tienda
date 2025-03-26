<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'id' => 1,
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        Role::firstOrCreate([
            'id' => 2,
            'name' => 'user',
            'guard_name' => 'web',
        ]);
        Role::firstOrCreate([
            'id' => 3,
            'name' => 'developer',
            'guard_name' => 'web',
        ]);
    }
}
