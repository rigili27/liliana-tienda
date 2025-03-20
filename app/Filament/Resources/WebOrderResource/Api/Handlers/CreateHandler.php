<?php
namespace App\Filament\Resources\WebOrderResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\WebOrderResource;
use App\Filament\Resources\WebOrderResource\Api\Requests\CreateWebOrderRequest;

use Illuminate\Support\Facades\Log;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = WebOrderResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create WebOrder
     *
     * @param CreateWebOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateWebOrderRequest $request)
    {
        // $model = new (static::getModel());
        // $model->fill($request->all());
        // $model->save();
        // return static::sendSuccessResponse($model, "Successfully Create Resource");


        $rawData = file_get_contents('php://input');
        
        // Comentar esta linea para produccion
        //$webOrderData = json_decode($rawData, true);

        // Comentar esta linea en dev
        $decodedData = base64_decode(json_decode($rawData, true)['data']);

        // Comentar esta linea en dev
        // Convertir a array PHP
        $webOrderData = json_decode($decodedData, true);

        Log::info('Decoded JSON received', ['data' => $webOrderData]);

    }
}