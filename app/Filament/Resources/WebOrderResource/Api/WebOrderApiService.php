<?php
namespace App\Filament\Resources\WebOrderResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\WebOrderResource;
use Illuminate\Routing\Router;


class WebOrderApiService extends ApiService
{
    protected static string | null $resource = WebOrderResource::class;

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
