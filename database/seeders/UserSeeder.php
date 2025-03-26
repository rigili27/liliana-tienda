<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'name' => 'Jesus',
                'cuit' => '00000000000',
                'email' => 'rigili27@gmail.com',
                'password' => Hash::make('asd123456'),
            ],
            [
                'name' => 'Liliana De Scisciolo',
                'cuit' => '27246848330',
                'email' => 'lilianadescisciolo@la27ferreteria.com.ar',
                'password' => Hash::make('8330'),
            ],
            [
                'name' => 'Gina Barra',
                'cuit' => '00000000000',
                'email' => 'ginabarra@la27ferreteria.com.ar',
                'password' => Hash::make('cambiar'),
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);

            // Asigna roles después de que el usuario ha sido creado
            $user->assignRole('admin');

            if ($user->email === 'rigili27@gmail.com') {
                $user->assignRole('developer');
            }
        }



        // User::create([
        //     'id' => 1,
        //     'name' => 'Jesus',
        //     'cuit' => '00000000000',
        //     'email' => 'rigili27@gmail.com',
        //     'password' => 'asd123456',
        // ]);

        // User::create([
        //     'id' => 2,
        //     'name' => 'Liliana De Scisciolo',
        //     'cuit' => '27246848330',
        //     'email' => 'lilianadescisciolo@la27ferreteria.com.ar',
        //     'password' => '8330',
        // ]);

        // User::create([
        //     'id' => 3,
        //     'name' => 'Gina Barra',
        //     'cuit' => '00000000000',
        //     'email' => 'ginabarra@la27ferreteria.com.ar',
        //     'password' => 'cambiar',
        // ]);

        // // pongo al users como admin
        // DB::table('model_has_roles')->insert([
        //     'role_id' => 1,
        //     'model_type' => 'App\Models\User',
        //     'model_id' => 1,
        // ]);
        // DB::table('model_has_roles')->insert([
        //     'role_id' => 1,
        //     'model_type' => 'App\Models\User',
        //     'model_id' => 2,
        // ]);
        // DB::table('model_has_roles')->insert([
        //     'role_id' => 1,
        //     'model_type' => 'App\Models\User',
        //     'model_id' => 3,
        // ]);

        // // pongo al users como developer
        // DB::table('model_has_roles')->insert([
        //     'role_id' => 3,
        //     'model_type' => 'App\Models\User',
        //     'model_id' => 1,
        // ]);
    }
}
