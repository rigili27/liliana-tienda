<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Category;
use App\Models\Family;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Business::create([
            'name' => 'La 27 Ferretería',
        ]);

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

        User::create([
            'id' => 1,
            'name' => 'Jesus',
            'cuit' => '00000000000',
            'email' => 'rigili27@gmail.com',
            'password' => 'asd123456',
        ]);

        User::create([
            'id' => 2,
            'name' => 'Liliana De Scisciolo',
            'cuit' => '27246848330',
            'email' => 'lilianadescisciolo@la27ferreteria.com.ar',
            'password' => '8330',
        ]);


        // pongo al users como admin
        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 2,
        ]);

        // pongo al users como developer
        DB::table('model_has_roles')->insert([
            'role_id' => 3,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);

        // Family::create([
        //     'name' => 'Family_Test',
        // ]);

        // Category::create([
        //     'name' => 'Category_Test',
        // ]);


    }
}
