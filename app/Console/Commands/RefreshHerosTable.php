<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshHerosTable extends Command
{
    protected $signature = 'migrate:heros';
    protected $description = 'Borra y recrea la tabla heros, luego ejecuta su seeder.';

    public function handle()
    {

        $migrationPath = 'database/migrations/0001_01_01_000060_create_heroes_table.php';

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

        return Command::SUCCESS;
    }
}
