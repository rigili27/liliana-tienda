<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshOrdersTable extends Command
{
    protected $signature = 'migrate:orders';
    protected $description = 'Borra y recrea la tabla orders, luego ejecuta su seeder.';

    public function handle()
    {

        $migrationPath = 'database/migrations/0001_01_01_000600_create_orders_table.php';

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
