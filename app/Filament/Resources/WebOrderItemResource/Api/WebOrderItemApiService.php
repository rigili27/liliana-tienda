<?php
namespace App\Filament\Resources\WebOrderItemResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\WebOrderItemResource;
use Illuminate\Routing\Router;


class WebOrderItemApiService extends ApiService
{
    protected static string | null $resource = WebOrderItemResource::class;

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
