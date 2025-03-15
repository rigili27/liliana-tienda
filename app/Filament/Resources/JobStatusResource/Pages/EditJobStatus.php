<?php

namespace App\Filament\Resources\JobStatusResource\Pages;

use App\Filament\Resources\JobStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobStatus extends EditRecord
{
    protected static string $resource = JobStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
