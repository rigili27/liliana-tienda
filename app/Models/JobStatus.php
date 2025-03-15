<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    use HasFactory;

    protected $table = 'jobs_status';

    /**
     * Campos asignables en masa.
     */
    protected $fillable = [
        'job_name',
        'payload',
        'status',
        'progress',
        'error_message',
    ];

    /**
     * Indica si los campos `created_at` y `updated_at` están habilitados.
     */
    public $timestamps = true;

    /**
     * Define si el job está marcado como en proceso.
     */
    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    /**
     * Marca el job como fallido.
     */
    public function markAsFailed(string $message)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $message,
        ]);
    }

    /**
     * Marca el job como completado.
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'progress' => 100,
        ]);
    }
}
