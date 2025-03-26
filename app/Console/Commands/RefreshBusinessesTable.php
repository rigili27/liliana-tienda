<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshBusinessesTable extends Command
{
    protected $signature = 'migrate:businesses';
    protected $description = 'Borra y recrea la tabla businesses, luego ejecuta su seeder.';

    public function handle()
    {
        $migrationPath = 'database/migrations/0001_01_01_000050_create_businesses_table.php';

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
            '--class' => 'BusinessSeeder',
            '--force' => true
        ]);

        $this->info("✅ Seeder ejecutado correctamente.");

        return Command::SUCCESS;
    }
}
