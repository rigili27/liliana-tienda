<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Family;
use App\Models\Category;
use App\Models\JobStatus;
use Illuminate\Support\Facades\Log;

class FamilyCreateHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $records;
    public $jobStatusId;

    /**
     * Create a new job instance.
     */
    public function __construct(array $records, ?int $jobStatusId = null)
    {
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
                Log::info('Procesando registro', ['record' => $record]);

                // Mapear campos
                $mappedRecord = $this->mapFields($record);

                // Dividir y determinar si es Family o Category
                $codrubro = $mappedRecord['id'];
                $familyId = substr($codrubro, 0, 3); // Primeros 3 dígitos
                $categoryId = substr($codrubro, 3, 3); // Últimos 3 dígitos

                if ($categoryId === '000') {
                    // Es un registro de Family
                    $this->handleFamily((int)$familyId, $mappedRecord);
                } else {
                    // Es un registro de Category
                    $this->handleCategory((int)$familyId, $categoryId, $mappedRecord);
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
    }

    /**
     * Mapea los nombres de los campos recibidos a los nombres de los campos de la base de datos.
     */
    protected function mapFields(array $data): array
    {
        $fieldMapping = [
            'Codrubro' => 'id',
            'Descripcion' => 'name',
        ];

        $mappedData = [];
        foreach ($data as $key => $value) {
            $mappedData[$fieldMapping[$key] ?? $key] = $value;
        }

        return $mappedData;
    }

    /**
     * Procesa un registro de Family.
     */
    protected function handleFamily(string $familyId, array $record): void
    {
        $familyData = [
            'id' => $familyId . '000',
            // 'id' => $familyId,
            'name' => $record['name'] ?? null,
        ];

        $existingFamily = Family::find($familyData['id']);

        if ($existingFamily) {
            if ($existingFamily->name === $familyData['name']) {
                Log::info("Registro de Family sin cambios", $familyData);
                return;
            }
        }

        Family::updateOrCreate(['id' => $familyData['id']], $familyData);
        Log::info("Registro de Family procesado", $familyData);
    }

    /**
     * Procesa un registro de Category.
     */
    protected function handleCategory(string $familyId, string $categoryId, array $record): void
    {
        $categoryData = [
            'id' => $familyId . $categoryId,
            // 'id' => $categoryId,
            'name' => $record['name'] ?? null,
        ];

        $existingCategory = Category::find($categoryData['id']);

        if ($existingCategory) {
            if ($existingCategory->name === $categoryData['name']) {
                Log::info("Registro de Category sin cambios", $categoryData);
                return;
            }
        }

        Category::updateOrCreate(['id' => $categoryData['id']], $categoryData);
        Log::info("Registro de Category procesado", $categoryData);
    }
}
