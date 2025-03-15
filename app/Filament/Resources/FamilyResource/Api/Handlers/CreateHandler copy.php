<?php
namespace App\Filament\Resources\FamilyResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\FamilyResource;
use App\Jobs\FamilyCreateHandlerJob;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = FamilyResource::class;

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
        // $model = new (static::getModel());
        // $model->fill($request->all());
        // $model->save();
        // return static::sendSuccessResponse($model, "Successfully Create Resource");

        if (empty($request->all())) {
            return response()->json(['error' => 'No family data provided'], 400);
        }

        FamilyCreateHandlerJob::dispatch($request->all());
        return response()->json(['message' => 'Family creation is processing'], 202);
    }
}