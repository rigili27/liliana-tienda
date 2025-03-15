<?php
namespace App\Filament\Resources\UserResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\UserResource;
use App\Jobs\UserCreateHandlerJob;
use App\Models\JobStatus;
use Illuminate\Support\Facades\Log;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = UserResource::class;

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
        //$userData = json_decode($rawData, true);

        // Comentar esta linea en dev
        $decodedData = base64_decode(json_decode($rawData, true)['data']);

        // Comentar esta linea en dev
        // Convertir a array PHP
        $userData = json_decode($decodedData, true);

        Log::info('Decoded JSON received', ['data' => $userData]);

        if (empty($userData)) {
            return response()->json(['error' => 'No user data provided'], 400);
        }

        $chunks = collect($userData)->chunk(500);
        foreach ($chunks as $chunk) {

            $jobStatus = JobStatus::create([
                'job_name' => 'UserCreateHandlerJob',
                'status' => 'pending',
                'progress' => 0,
                'payload' => json_encode($chunk->toArray()),
            ]);
            
            Log::info('Creando Job para un chunk', ['job_status_id' => $jobStatus->id]);
            UserCreateHandlerJob::dispatch($chunk->toArray(), $jobStatus->id);
        }

        // return response()->json(['message' => 'User creation jobs dispatched'], 202);
        return response()->json(['message' => 'Usuarios enviados correctamente.'], 202);
    }
}