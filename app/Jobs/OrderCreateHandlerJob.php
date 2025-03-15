<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Filament\Resources\OrderResource;
use App\Models\JobStatus;
// use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class OrderCreateHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orders;
    public $jobStatusId;

    public static string | null $resource = OrderResource::class;

    /**
     * Create a new job instance.
     */
    public function __construct(array $orders, int $jobStatusId)
    {
        $this->orders = $orders;
        $this->jobStatusId = $jobStatusId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobStatus = JobStatus::find($this->jobStatusId);

        if (!$jobStatus) {
            Log::error("No se encontró el registro del JobStatus con ID: {$this->jobStatusId}");
            return;
        }

        $totalRecords = count($this->orders);
        $processedCount = 0;

        foreach ($this->orders as $key => $value) {
            try {
                $jobStatus->update(['status' => 'in_progress']);
                $progress = 0;

                Log::info('Datos recibidos para orden', ['value' => $value]);

                $model = new (static::getModel());

                // Mapear y filtrar los datos
                $mappedData = $this->mapFields($value);
                $filteredFields = $this->filterFields($mappedData, $model);

                if (isset($filteredFields['id'])) {
                    $order = $this->updateOrCreateRecord($filteredFields, $model);
                } else {
                    $order = $this->createNewRecord($filteredFields, $model);
                }

                // Actualizar progreso
                $processedCount++;
                $progress = ($processedCount / $totalRecords) * 100;
                $jobStatus->update(['progress' => $progress]);
            } catch (\Exception $e) {
                $jobStatus->markAsFailed($e->getMessage());
                Log::error("Error en el Job", ['job_status_id' => $this->jobStatusId, 'message' => $e->getMessage()]);
            }
        }


        $jobStatus->markAsCompleted();
        Log::info("Job completado exitosamente", ['job_status_id' => $this->jobStatusId]);



        // try {
        //     $jobStatus->update(['status' => 'in_progress']);
        //     $progress = 0;

        //     foreach ($this->orders as $key => $value) {
        //         Log::info('Datos recibidos para orden', ['value' => $value]);

        //         $model = new (static::getModel());

        //         // Mapear y filtrar los datos
        //         $mappedData = $this->mapFields($value);
        //         $filteredFields = $this->filterFields($mappedData, $model);

        //         if (isset($filteredFields['id'])) {
        //             $order = $this->updateOrCreateRecord($filteredFields, $model);
        //         } else {
        //             $order = $this->createNewRecord($filteredFields, $model);
        //         }

        //         // Actualizar progreso
        //         $progress = intval((($key + 1) / count($this->orders)) * 100);
        //         $jobStatus->update(['progress' => $progress]);
        //     }

        //     $jobStatus->markAsCompleted();
        //     Log::info("Job completado exitosamente", ['job_status_id' => $this->jobStatusId]);
        // } catch (\Exception $e) {
        //     $jobStatus->markAsFailed($e->getMessage());
        //     Log::error("Error en el Job", ['job_status_id' => $this->jobStatusId, 'message' => $e->getMessage()]);
        // }



        // $jobStatus->update([
        //     'status' => 'completed',
        //     'message' => 'Order processing completed',
        // ]);
    }

    /**
     * Mapea los nombres de los campos recibidos a los nombres de los campos de la base de datos.
     */
    protected function mapFields(array $data): array
    {
        $fieldMapping = [
            'Clave' => 'id',
            'Fecha' => 'fecha',
            'Fechavto' => 'fechavto',
            'Tipomov' => 'tipomov',
            'Talonario' => 'talonario',
            'Nrocomprobante' => 'nrocomprobante',
            'Codadminis' => 'codadminis',
            'Condvta' => 'condvta',
            'Codcliente' => 'user_id',
            'Nombre' => 'nombre',
            'Nrocuit' => 'nrocuit',
            'Codcativa' => 'codcativa',
            'Domicilio' => 'domicilio',
            'Codlocalidad' => 'codlocalidad',
            'Tipoprecios' => 'tipoprecios',
            'Nrolispre' => 'nrolispre',
            'Neto1' => 'neto1',
            'Poriva1' => 'poriva1',
            'Impiva1' => 'impiva1',
            'Neto2' => 'neto2',
            'Poriva2' => 'poriva2',
            'Impiva2' => 'impiva2',
            'Neto3' => 'neto3',
            'Poriva3' => 'poriva3',
            'Impiva3' => 'impiva3',
            'Impiinterno' => 'impiinterno',
            'Retganancias' => 'retganancias',
            'Retiva' => 'retiva',
            'Retibruto' => 'retibruto',
            'Percepciones' => 'percepciones',
            'Sellado' => 'sellado',
            'Totalgral' => 'totalgral',
            'Totchqcar' => 'totchqcar',
            'Totefectivo' => 'totefectivo',
            'Tottransferencia' => 'tottransferencia',
            'Totcanje' => 'totcanje',
            'Marcacont' => 'marcacont',
            'Marcaestado' => 'marcaestado',
            'Ventaanticipada' => 'ventaanticipada',
            'Nota' => 'nota',
            'Cotizdolar' => 'cotizdolar',
            'Novaaliva' => 'novaaliva',
            'Notamovimiento' => 'notamovimiento',
            'Marcafcanje' => 'marcafcanje',
            'Idivacanje' => 'idivacanje',
            'Numerorto' => 'numerorto',
            'Coddeposito' => 'coddeposito',
            'Dolar' => 'dolar',
            'Marcaanulado' => 'marcaanulado',
            'Nrocae' => 'nrocae',
            'Fechacae' => 'fechacae',
            'Letrafactura' => 'letrafactura',
            'idCobranza' => 'idCobranza',
            'Imagen' => 'attach',
            'MovSArt' => 'movsart',
            'MarcaRVal' => 'marcarval',
            'IdRecValores' => 'idrecvalores',


        ];

        $mappedData = [];
        foreach ($data as $key => $value) {
            $mappedKey = $fieldMapping[$key] ?? $key;
            $mappedData[$mappedKey] = is_string($value) ? trim($value) : $value;
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
    protected function updateOrCreateRecord(array $filteredFields, $model)
    {
        Log::info('Intentando actualizar o crear registro con ID:', ['id' => $filteredFields['id']]);

        // Validación y codificación Base64 de `attach`
        if (strpos($filteredFields['attach'], 'data:application/pdf;base64,') === 0) {
            $filteredFields['attach'] = str_replace('data:application/pdf;base64,', '', $filteredFields['attach']);
        }

        $existingRecord = $model::find($filteredFields['id']);
        if ($existingRecord) {
            if ($this->hasChanges($existingRecord, $filteredFields)) {
                $existingRecord->update($filteredFields);
                Log::info("Registro de orden actualizado con ID: {$filteredFields['id']}");
            } else {
                Log::info("Sin cambios para la orden con ID: {$filteredFields['id']}");
            }
            return $existingRecord;
        } else {
            return $this->createNewRecord($filteredFields, $model);
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
    protected function createNewRecord(array $filteredFields, $model)
    {
        Log::info('Creando un nuevo registro de orden:', $filteredFields);
        $model->fill($filteredFields);
        $model->save();
        return $model;
    }

    /**
     * Obtiene el modelo relacionado al recurso.
     */
    public static function getModel()
    {
        return static::$resource::getModel();
    }
}
