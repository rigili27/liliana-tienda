<?php

namespace App\Filament\Resources\JobStatusResource\Pages;

use App\Filament\Resources\JobStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJobStatus extends CreateRecord
{
    protected static string $resource = JobStatusResource::class;
}
