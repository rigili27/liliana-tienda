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

        $this->call([
            BusinessSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);


    }
}
