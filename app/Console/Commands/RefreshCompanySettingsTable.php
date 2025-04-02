<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshCompanySettingsTable extends Command
{
    protected $signature = 'migrate:company_settings';
    protected $description = 'Borra y recrea la tabla company_settings, luego ejecuta su seeder.';

    public function handle()
    {
        $migrationPath = 'database/migrations/0001_01_01_000052_create_company_settings_table.php';

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
            '--class' => 'CompanySettingSeeder',
            '--force' => true
        ]);

        $this->info("✅ Seeder ejecutado correctamente.");

        return Command::SUCCESS;
    }
}
