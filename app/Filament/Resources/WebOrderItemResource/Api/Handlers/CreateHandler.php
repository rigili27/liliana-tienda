<?php
namespace App\Filament\Resources\WebOrderItemResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\WebOrderItemResource;
use App\Filament\Resources\WebOrderItemResource\Api\Requests\CreateWebOrderItemRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = WebOrderItemResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create WebOrderItem
     *
     * @param CreateWebOrderItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateWebOrderItemRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}