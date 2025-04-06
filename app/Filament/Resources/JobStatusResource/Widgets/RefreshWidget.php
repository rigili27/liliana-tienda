<?php

namespace App\Filament\Resources\JobStatusResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

class RefreshWidget extends Widget
{
    protected static string $view = 'filament.resources.job-status-resource.widgets.refresh-widget';

    protected static bool $isLazy = false; // Para asegurarnos de que el widget se renderice correctamente.

    public function refreshBusinesses()
    {
        try {
            Artisan::call('migrate:businesses');

            Notification::make()
                ->title('Éxito')
                ->body('La tabla de negocios fue refrescada correctamente.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('No se pudo refrescar la tabla de negocios.')
                ->danger()
                ->send();
        }
    }

    public function refreshUsers()
    {
        try {
            Artisan::call('migrate:users');

            Notification::make()
                ->title('Éxito')
                ->body('La tabla de users fue refrescada correctamente.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('No se pudo refrescar la tabla de users.')
                ->danger()
                ->send();
        }
    }

    public function refreshOrders()
    {
        try {
            Artisan::call('migrate:orders');

            Notification::make()
                ->title('Éxito')
                ->body('La tabla de orders fue refrescada correctamente.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('No se pudo refrescar la tabla de orders.')
                ->danger()
                ->send();
        }
    }

    public function refreshProducts()
    {
        try {
            Artisan::call('migrate:products');

            Notification::make()
                ->title('Éxito')
                ->body('La tabla de products fue refrescada correctamente.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('No se pudo refrescar la tabla de products.')
                ->danger()
                ->send();
        }
    }

    public function refreshCompanySettings()
    {
        try {
            Artisan::call('migrate:company_settings');

            Notification::make()
                ->title('Éxito')
                ->body('La tabla de company_settings fue refrescada correctamente.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('No se pudo refrescar la tabla de company_settings.')
                ->danger()
                ->send();
        }
    }

    public function refreshHeros()
    {
        try {
            Artisan::call('migrate:heros');

            Notification::make()
                ->title('Éxito')
                ->body('La tabla de heros fue refrescada correctamente.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('No se pudo refrescar la tabla de heros.')
                ->danger()
                ->send();
        }
    }
}
