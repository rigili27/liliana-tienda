<?php

namespace App\Filament\Resources\WebOrderItemResource\Pages;

use App\Filament\Resources\WebOrderItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebOrderItem extends EditRecord
{
    protected static string $resource = WebOrderItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
