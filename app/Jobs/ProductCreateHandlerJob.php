<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Family;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\JobStatus;
use App\Models\Product; // Asegúrate de tener el modelo de producto
use Illuminate\Support\Facades\Log;

class ProductCreateHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $products;
    public $jobStatusId;

    /**
     * Crea una nueva instancia del Job.
     */
    public function __construct(array $products, int $jobStatusId)
    {
        $this->products = $products;
        $this->jobStatusId = $jobStatusId;
    }

    /**
     * Ejecuta el Job.
     */
    public function handle(): void
    {
        $jobStatus = JobStatus::find($this->jobStatusId);

        if (!$jobStatus) {
            Log::error("No se encontró el registro del JobStatus con ID: {$this->jobStatusId}");
            return;
        }

        try {
            $jobStatus->update(['status' => 'in_progress']);
            $progress = 0;

            foreach ($this->products as $key => $value) {
                Log::info("Procesando producto {$key}", ['data' => $value]);

                // Mapear y filtrar campos
                $mappedData = $this->mapFields($value);
                $filteredData = $this->filterFields($mappedData, new Product());

                // Crear o actualizar el registro
                $this->updateOrCreateRecord($filteredData, new Product());

                // Actualizar progreso
                $progress = intval((($key + 1) / count($this->products)) * 100);
                $jobStatus->update(['progress' => $progress]);
            }

            $jobStatus->markAsCompleted();
            Log::info("Job completado exitosamente", ['job_status_id' => $this->jobStatusId]);
        } catch (\Exception $e) {
            // $jobStatus->markAsFailed($e->getMessage());
            // Log::error("Error en el Job", ['job_status_id' => $this->jobStatusId, 'message' => $e->getMessage()]);

            $errorMessage = $e->getMessage();

            // Capturar violación de clave foránea (error 1452)
            if ($e->getCode() == '23000') {
                Log::error("Violación de clave foránea en el Job", [
                    'job_status_id' => $this->jobStatusId,
                    'error_message' => $errorMessage
                ]);

                $errorMessage = $this->getForeignKeyErrorMessage($filteredData);
            }

            // Guardar el mensaje en JobStatus antes de lanzar la excepción
            $jobStatus->markAsFailed($errorMessage);

            Log::error("Error en el Job", [
                'job_status_id' => $this->jobStatusId,
                'message' => $errorMessage
            ]);

            throw new \Exception($errorMessage);
        }
    }

    /**
     * Mapea los nombres de los campos recibidos a los nombres de los campos de la base de datos.
     */
    protected function mapFields(array $data): array
    {
        $fieldMapping = [

            // 'codigo' => 'id',
            // 'nombre' => 'name',
            // 'descripcion' => 'description',
            // 'rubros_id' => 'family_id',
            // 'sub_rubros_id' => 'category_id',
            // 'tags' => 'tags',
            // 'cantidad' => 'stock',
            // 'precio_oferta' => 'off_price',
            // 'porc_oferta' => 'off_porc',
            // 'precio_dolar' => 'dolar_price',
            // 'precio_1' => 'price_1',
            // 'precio_2' => 'price_2',
            // 'precio_3' => 'price_3',
            // 'precio_m_1' => 'price_m_1',
            // 'precio_m_2' => 'price_m_2',
            // 'precio_m_3' => 'price_m_3',
            // 'es_oferta' => 'is_off',
            // 'es_nuevo' => 'is_new',
            // 'activo' => 'active',
            // 'CodOrigen' => 'sku',
            // 'CodDeBarra' => 'bar_code',
            'Imagen' => 'image_url',

            'Codigo' => 'id',
            'Descripcion' => 'name',
            // 'Codrubro' => 'family_id',
            // 'Codtipoiva' => '',
            'Stockactual' => 'stock',
            'Prevtapub1' => 'price_1',
            'Prevtapub2' => 'price_2',
            'Prevtapub3' => 'price_3',
            'Prevtamay1' => 'price_m_1',
            'Prevtamay2' => 'price_m_2',
            'Prevtamay3' => 'price_m_3',
            // 'Monedadolar' => '',
            // 'fupcosto' => '',
            // 'Alicuota' => '',
            'Codigobarra' => 'bar_code',
            'Codorigen' => 'sku',
        ];

        $mappedData = [];
        foreach ($data as $key => $value) {
            if ($key === 'Codrubro') {
                // $mappedData[$fieldMapping[$key]] = (int)$value;

                $family_id = substr($value, 0, 3); // Extrae los primeros 3 dígitos
                $category_id = substr($value, 3, 3); // Extrae los últimos 3 dígitos

                
                $mappedData['family_id'] = (int) ($family_id . '000');
                $mappedData['category_id'] = (int) ($family_id . $category_id);
                

            } elseif ($key === 'Imagen') {
                $mappedData[$fieldMapping[$key]] = $this->transformPhotoPath($value);
            } else {
                $mappedData[$fieldMapping[$key] ?? $key] = $value;
            }
        }

        return $mappedData;
    }

    /**
     * Transforma la ruta del archivo de fotos según las condiciones especificadas.
     */
    protected function transformPhotoPath(?string $photoPath): array
    {
        if (!empty($photoPath) && preg_match('/([^\/]+)$/', $photoPath, $matches)) {
            $fileName = 'product-' . $matches[1];
            Log::info('Ruta procesada correctamente:', ['fileName' => $fileName]);
            return [$fileName];
        }

        Log::info('Campo fotos vacío o no coincide, devolviendo array vacío');
        return [];
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
     * Verifica la existencia de las claves foráneas en la base de datos.
     */
    protected function checkForeignKeys(array $filteredData): void
    {
        $familyExists = Family::find($filteredData['family_id']);
        $categoryExists = Category::find($filteredData['category_id']);

        if (!$familyExists) {
            throw new \Exception("El Rubro con ID {$filteredData['family_id']} no existe.");
        }

        if (!$categoryExists) {
            throw new \Exception("El SubRubro con ID {$filteredData['category_id']} no existe.");
        }
    }

    /**
     * Obtiene el mensaje de error dependiendo de qué clave foránea está mal.
     */
    protected function getForeignKeyErrorMessage(array $filteredData): string
    {
        $familyExists = Family::find($filteredData['family_id']);
        $categoryExists = Category::find($filteredData['category_id']);

        if (!$familyExists && !$categoryExists) {
            return "El Rubro con ID {$filteredData['family_id']} y el SubRubro con ID {$filteredData['category_id']} no existen.";
        } elseif (!$familyExists) {
            return "El Rubro con ID {$filteredData['family_id']} no existe.";
        } elseif (!$categoryExists) {
            return "El SubRubro con ID {$filteredData['category_id']} no existe.";
        }

        return "Error desconocido en las claves foráneas.";
    }

    /**
     * Actualiza un registro existente si hay cambios, o lo crea si no existe.
     */
    protected function updateOrCreateRecord(array $filteredFields, $model): void
    {
        Log::info('Intentando actualizar o crear registro con ID:', ['id' => $filteredFields['id']]);

        // $existingRecord = $model::find($filteredFields['id']);
        $existingRecord = $model::withTrashed()->find($filteredFields['id']);

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
        $model->create($filteredFields);
    }
}
