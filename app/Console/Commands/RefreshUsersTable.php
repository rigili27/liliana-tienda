<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshUsersTable extends Command
{
    protected $signature = 'migrate:users';
    protected $description = 'Borra y recrea la tabla users, luego ejecuta su seeder.';

    public function handle()
    {
        $migrationPath = 'database/migrations/0001_01_01_000000_create_users_table.php';

        $this->info("⏳ Revirtiendo migración...");
        Artisan::call('migrate:refresh', [
            '--path' => $migrationPath,
            '--force' => true
        ]);

        $this->info("✅ Migración revertida.");
        $this->info("⏳ Ejecutando migración nuevamente...");

        Artisan::call('migrate', [
            '--path' => $migrationPath,
            '--force' => true
        ]);

        $this->info("✅ Migración ejecutada correctamente.");
        $this->info("⏳ Ejecutando Seeder...");

        Artisan::call('db:seed', [
            '--class' => 'UserSeeder',
            '--force' => true
        ]);

        $this->info("✅ Seeder ejecutado correctamente.");

        return Command::SUCCESS;
    }
}
