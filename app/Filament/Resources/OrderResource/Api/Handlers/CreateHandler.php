<?php
namespace App\Filament\Resources\OrderResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\OrderResource;
use App\Jobs\OrderCreateHandlerJob;
use Illuminate\Support\Facades\Log;
use App\Models\JobStatus;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = OrderResource::class;

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


        $rawData = file_get_contents('php://input');
        
        // Comentar esta linea para produccion
        //$orderData = json_decode($rawData, true);

        // Comentar esta linea en dev
        $decodedData = base64_decode(json_decode($rawData, true)['data']);

        // Comentar esta linea en dev
        // Convertir a array PHP
        $orderData = json_decode($decodedData, true);

        Log::info('Decoded JSON received', ['data' => $orderData]);

        if (empty($orderData)) {
            return response()->json(['error' => 'No order data provided'], 400);
        }

        $chunks = collect($orderData)->chunk(500);

        foreach ($chunks as $chunk) {
            $jobStatus = JobStatus::create([
                'job_name' => 'OrderCreateHandlerJob',
                'status' => 'pending',
                'progress' => 0,
                'payload' => json_encode($chunk->toArray()),
            ]);

            Log::info('Creando Job para un chunk', ['job_status_id' => $jobStatus->id]);
            OrderCreateHandlerJob::dispatch($chunk->toArray(), $jobStatus->id);
        }

        return response()->json([
            'message' => 'Ordenes enviadas correctamente.'], 202);
    }
}
