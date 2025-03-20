<?php
namespace App\Filament\Resources\WebOrderItemResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\WebOrderItemResource;
use App\Filament\Resources\WebOrderItemResource\Api\Requests\UpdateWebOrderItemRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = WebOrderItemResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update WebOrderItem
     *
     * @param UpdateWebOrderItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateWebOrderItemRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}