<?php
namespace App\Filament\Resources\FamilyResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\FamilyResource;
use Illuminate\Routing\Router;


class FamilyApiService extends ApiService
{
    protected static string | null $resource = FamilyResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
