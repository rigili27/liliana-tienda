<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Filament\Resources\OrderResource;
use App\Models\JobStatus;
use App\Models\OrderItem;
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

        try {
            $jobStatus->update(['status' => 'in_progress']);
            $progress = 0;

            foreach ($this->orders as $key => $value) {
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
    
                // Procesar los detalles de la orden
                if (isset($value['detalle']) && is_array($value['detalle'])) {
                    $this->processOrderItems($order, $value['detalle']);
                }

                // Actualizar progreso
                $progress = intval((($key + 1) / count($this->orders)) * 100);
                $jobStatus->update(['progress' => $progress]);
                
            }

            $jobStatus->markAsCompleted();
            Log::info("Job completado exitosamente", ['job_status_id' => $this->jobStatusId]);


        } catch (\Exception $e) {
            $jobStatus->markAsFailed($e->getMessage());
            Log::error("Error en el Job", ['job_status_id' => $this->jobStatusId, 'message' => $e->getMessage()]);
        }

        

        $jobStatus->update([
            'status' => 'completed',
            'message' => 'Order processing completed',
        ]);
    }

    /**
     * Mapea los nombres de los campos recibidos a los nombres de los campos de la base de datos.
     */
    protected function mapFields(array $data): array
    {
        $fieldMapping = [
            'id' => 'id',
            'user' => 'user_id',
            'prefijo' => 'prefix',
            'factura_nro' => 'number',
            'letra' => 'letter',
            'tipo_mov' => 'type_mov',
            'fecha' => 'date',
            'nombre' => 'user_name',
            'direccion' => 'user_address',
            'cuit' => 'user_cuit',
            'cond_iva' => 'cond_iva',
            'cond_venta' => 'cond_venta',
            'neto_1' => 'neto_1',
            'alicuota_1' => 'alicuota_1',
            'imp_iva_1' => 'imp_iva_1',
            'neto_2' => 'neto_2',
            'alicuota_2' => 'alicuota_2',
            'imp_iva_2' => 'imp_iva_2',
            'neto_3' => 'neto_3',
            'alicuota_3' => 'alicuota_3',
            'imp_iva_3' => 'imp_iva_3',
            'imp_interno' => 'imp_interno',
            'imp_dto' => 'imp_dto',
            'precepciones' => 'precepciones',
            'total' => 'total',
            'cae' => 'cae',
            'date_vto_cae' => 'date_vto_cae',
            'mov_sart' => 'mov_sart',
            'estable' => 'estable',
            'attach' => 'attach'
        ];

        $mappedData = [];
        foreach ($data as $key => $value) {
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
     * Procesa los detalles de la orden y llena la tabla order_items.
     */
    protected function processOrderItems($order, array $details): void
    {
        foreach ($details as $detail) {
            $mappedDetail = $this->mapOrderItemFields($detail);

            // Log::info('Condiciones para OrderItem:', [
            //     'order_id' => $order->id,
            //     'product_id' => $mappedDetail['product_id'],
            // ]);

            // Log::info('Valores para guardar o actualizar OrderItem:', [
            //     'unit_price' => $mappedDetail['unit_price'],
            //     'description' => $mappedDetail['description'],
            //     'quantity' => $mappedDetail['quantity'],
            //     'alicuota' => $mappedDetail['alicuota'],
            //     'importe' => $mappedDetail['importe'],
            // ]);

            if (isset($mappedDetail['order_id'], $mappedDetail['product_id'])) {
                OrderItem::updateOrCreate(
                    [
                        'order_id' => $order->id,
                        'product_id' => $mappedDetail['product_id'],
                    ],
                    [
                        'unit_price' => $mappedDetail['unit_price'],
                        'description' => $mappedDetail['description'],
                        'quantity' => $mappedDetail['quantity'],
                        'alicuota' => $mappedDetail['alicuota'],
                        'importe' => $mappedDetail['importe'],
                    ]
                );

                Log::info("Detalle de orden procesado para Order ID: {$order->id}, Product ID: {$mappedDetail['product_id']}");
            } else {
                Log::warning("Detalle de orden inválido:", $detail);
            }
        }
    }

    /**
     * Mapea los nombres de los campos de detalle a los de la base de datos.
     */
    protected function mapOrderItemFields(array $detail): array
    {
        $fieldMapping = [
            'deuda_id' => 'order_id',
            'articulo_id' => 'product_id',
            'descripcion' => 'description',
            'cantidad' => 'quantity',
            'precio_unitario' => 'unit_price',
            'alicuota' => 'alicuota',
            'importe' => 'importe'
        ];

        $mappedDetail = [];
        foreach ($detail as $key => $value) {
            $mappedDetail[$fieldMapping[$key] ?? $key] = $value;
        }

        return $mappedDetail;
    }

    /**
     * Obtiene el modelo relacionado al recurso.
     */
    public static function getModel()
    {
        return static::$resource::getModel();
    }
}
