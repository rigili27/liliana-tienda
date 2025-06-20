<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Filament\Resources\UserResource;
use App\Models\JobStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserCreateHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $records;
    public $jobStatusId;

    public static string | null $resource = UserResource::class;

    /**
     * Create a new job instance.
     */
    public function __construct(array $records, ?int $jobStatusId = null)
    {
        // $this->users = $users;
        $this->records = is_array($records) ? $records : [];
        $this->jobStatusId = $jobStatusId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $jobStatus = JobStatus::find($this->jobStatusId);

        if (!$jobStatus) {
            Log::error('No se encontró el registro de JobStatus', ['jobStatusId' => $this->jobStatusId]);
            return;
        }

        $totalRecords = count($this->records);
        $processedCount = 0;

        foreach ($this->records as $record) {
            try {

                $jobStatus->update(['status' => 'in_progress']);
                $progress = 0;

                Log::info('Procesando registro', ['record' => $record]);

                $model = new (static::getModel());

                // Mapear y filtrar los datos
                $mappedData = $this->mapFields($record);
                $filteredFields = $this->filterFields($mappedData, $model);

                // Verificar si el campo "password" está vacío
                // if (empty($filteredFields['password'])) {
                //     Log::warning('Usuario omitido porque el campo "password" está vacío', ['record' => $filteredFields]);
                //     continue; // Salta este registro y pasa al siguiente
                // }
                
                // creo los usuarios
                if ($filteredFields['cuit'] > 1 && $filteredFields['password'] != '')
                    $filteredFields['email'] = $filteredFields['cuit'] . '@la27ferreteria.com.ar';
                else
                    $filteredFields['email'] = $filteredFields['id'] . '@la27ferreteria.com.ar';


                Log::info('Datos nuevos son ', ['value' => $filteredFields]);

                // Verificar si el usuario tiene un rol asignado en la tabla model_has_roles
                if (isset($filteredFields['id'])) {
                    $roleExists = DB::table('model_has_roles')
                        ->where('model_id', $filteredFields['id'])
                        ->where('model_type', 'App\Models\User')
                        ->exists();

                    if (!$roleExists) {
                        DB::table('model_has_roles')->insert([
                            'role_id' => 2,
                            'model_type' => 'App\Models\User',
                            'model_id' => $filteredFields['id'],
                        ]);

                        Log::info("Asignado rol ID 1 al usuario con ID: {$filteredFields['id']}");
                    }
                }


                if (isset($filteredFields['id'])) {
                    $this->updateOrCreateRecord($filteredFields, $model);
                } else {
                    $this->createNewRecord($filteredFields, $model);
                }

                $processedCount++;
                $progress = ($processedCount / $totalRecords) * 100;

                // Actualizar progreso del JobStatus
                $jobStatus->update([
                    'progress' => $progress,
                ]);
            } catch (\Exception $e) {
                $jobStatus->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);

                Log::error("Error procesando registro", [
                    'record' => $record,
                    'message' => $e->getMessage(),
                ]);
                return;
            }
        }

        $jobStatus->update([
            'status' => 'completed',
            'progress' => 100,
        ]);

        // foreach ($this->users as $key => $value) {
        //     Log::info('Datos recibidos son ', ['value' => $value]);

        //     $model = new (static::getModel());

        //     // Mapear y filtrar los datos
        //     $mappedData = $this->mapFields($value);
        //     $filteredFields = $this->filterFields($mappedData, $model);


        //     // Si email esta vacio, asigno uno con su cuit @dominio
        //     if ($filteredFields['email'] == '')
        //         $filteredFields['email'] = $filteredFields['cuit'] . '@la27ferreteria.com.ar';


        //     Log::info('Datos nuevos son ', ['value' => $filteredFields]);

        //     // Verificar si el usuario tiene un rol asignado en la tabla model_has_roles
        //     // if (isset($filteredFields['id'])) {
        //     //     $roleExists = DB::table('model_has_roles')
        //     //         ->where('model_id', $filteredFields['id'])
        //     //         ->where('model_type', 'App\Models\User')
        //     //         ->exists();

        //     //     if (!$roleExists) {
        //     //         DB::table('model_has_roles')->insert([
        //     //             'role_id' => 1,
        //     //             'model_type' => 'App\Models\User',
        //     //             'model_id' => $filteredFields['id'],
        //     //         ]);

        //     //         Log::info("Asignado rol ID 1 al usuario con ID: {$filteredFields['id']}");
        //     //     }
        //     // }


        //     if (isset($filteredFields['id'])) {
        //         $this->updateOrCreateRecord($filteredFields, $model);
        //     } else {
        //         $this->createNewRecord($filteredFields, $model);
        //     }
        // }
    }

    /**
     * Mapea los nombres de los campos recibidos a los nombres de los campos de la base de datos.
     */
    protected function mapFields(array $data): array
    {
        // Definir el mapeo entre los nombres externos y los de la base de datos
        $fieldMapping = [
            'Codigo' => 'id',
            'Nombre' => 'name',
            // 'Dircorreo' => 'email',
            'Password' => 'password',
            'Nrocuit' => 'cuit',
        ];

        $mappedData = [];
        foreach ($data as $key => $value) {
            // Usar el mapeo si el campo existe, de lo contrario ignorar el campo
            $mappedData[$fieldMapping[$key] ?? $key] = $value;
        }

        return $mappedData;
    }

    /**
     * Filtra los campos de entrada para que coincidan con los fillable del modelo.
     */
    protected function filterFields(array $fields, $model): array
    {
        $fillableFields = $model->getFillable();
        return array_intersect_key($fields, array_flip($fillableFields));
    }

    /**
     * Actualiza un registro existente si hay cambios, o lo crea si no existe.
     */
    protected function updateOrCreateRecord(array $filteredFields, $model): void
    {
        Log::info('Intentando actualizar o crear registro con ID:', ['id' => $filteredFields['id']]);

        $existingRecord = $model::find($filteredFields['id']);
        if ($existingRecord) {
            if ($this->hasChanges($existingRecord, $filteredFields)) {
                $existingRecord->update($filteredFields);
                Log::info("Registro actualizado con ID: {$filteredFields['id']}");
            } else {
                Log::info("Sin cambios para el registro con ID: {$filteredFields['id']}");
            }
        } else {
            $this->createNewRecord($filteredFields, $model);
        }
    }

    /**
     * Verifica si existen cambios entre el registro actual y los nuevos datos.
     */
    protected function hasChanges($existingRecord, array $newData): bool
    {
        foreach ($newData as $field => $newValue) {
            if ($existingRecord->{$field} !== $newValue) {
                return true;
            }
        }
        return false;
    }

    /**
     * Crea un nuevo registro.
     */
    protected function createNewRecord(array $filteredFields, $model): void
    {
        Log::info('Creando un nuevo registro:', $filteredFields);
        $model->fill($filteredFields);
        $model->save();
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }
}
