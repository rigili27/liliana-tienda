<?php
namespace App\Filament\Resources\ProductResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\ProductResource;
use App\Jobs\ProductCreateHandlerJob;
use Illuminate\Support\Facades\Log;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ProductResource::class;

    public static bool $public = true;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {
        // Codigo original
        // $model = new (static::getModel());
        // $model->fill($request->all());
        // $model->save();
        
        
        // Mi codigo

        // foreach ($request->all() as $key => $value) {
        //     $model = new (static::getModel());
        //     $model->fill($value); 
        //     $model->save();
        // }

        
        // Validar que $productData no esté vacío
        if (empty($request->all())) {
            return response()->json(['error' => 'No product data provided'], 400);
        }

        // ProductCreateHandlerJob::dispatch($request->all());
        // return response()->json(['message' => 'Product creation is processing'], 202);
        
        $chunks = collect($request->all())->chunk(300);
        foreach ($chunks as $chunk) {
            Log::info('Dividiendo la solicitud en chunks', ['total_chunks' => $chunks->count()]);
            ProductCreateHandlerJob::dispatch($chunk->toArray());
        }

        //
        
        // return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}