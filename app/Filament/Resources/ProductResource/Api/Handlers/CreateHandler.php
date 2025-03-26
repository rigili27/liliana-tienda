<?php

namespace App\Filament\Resources\ProductResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\ProductResource;
use App\Jobs\ProductCreateHandlerJob;
use App\Models\JobStatus;
use Illuminate\Support\Facades\Log;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ProductResource::class;

    public static bool $public = true;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public function handler(Request $request)
    {

        $rawData = file_get_contents('php://input');
        
        // Comentar esta linea para produccion
        // $productData = json_decode($rawData, true);

        // Comentar esta linea en dev
        $decodedData = base64_decode(json_decode($rawData, true)['data']);

        // Comentar esta linea en dev
        // Convertir a array PHP
        $productData = json_decode($decodedData, true);

        Log::info('Decoded JSON received', ['data' => $productData]);


        if (empty($productData)) {
            return response()->json(['error' => 'No product data provided'], 400);
        }

        $chunks = collect($productData)->chunk(500);

        foreach ($chunks as $chunk) {
            $jobStatus = JobStatus::create([
                'job_name' => 'ProductCreateHandlerJob',
                'status' => 'pending',
                'progress' => 0,
                'payload' => json_encode($chunk->toArray()),
            ]);

            Log::info('Creando Job para un chunk', ['job_status_id' => $jobStatus->id]);
            ProductCreateHandlerJob::dispatch($chunk->toArray(), $jobStatus->id);
        }

        return response()->json(['message' => 'Productos enviados correctamente.'], 202);
    }
}
