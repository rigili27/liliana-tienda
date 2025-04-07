<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshAttributesTable extends Command
{
    protected $signature = 'migrate:attributes';
    protected $description = 'Borra y recrea la tabla attributes, luego ejecuta su seeder.';

    public function handle()
    {
        $migrationPath = 'database/migrations/0001_01_01_000340_create_attributes_table.php';

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
            '--class' => 'AttributeSeeder',
            '--force' => true
        ]);

        $this->info("✅ Seeder ejecutado correctamente.");

        return Command::SUCCESS;
    }
}
