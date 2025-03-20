<?php
namespace App\Filament\Resources\WebOrderResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\WebOrderResource;
use App\Filament\Resources\WebOrderResource\Api\Requests\UpdateWebOrderRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = WebOrderResource::class;

    public static bool $public = true;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update WebOrder
     *
     * @param UpdateWebOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateWebOrderRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $rawData = file_get_contents('php://input');
        $webOrders = json_decode($rawData, true);
        
        $model->fill($webOrders);

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}