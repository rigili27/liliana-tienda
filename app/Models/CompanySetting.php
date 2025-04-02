<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;

class CompanySetting extends Model
{
    protected $fillable = [
        'id',
        'business_hours',
        'payment_methods',
        'delivery_methods',
        'address',
        'phone'
    ];

    protected function casts(): array
    {
        return [
            'business_hours' => 'array', // Laravel convierte automáticamente el JSON
            'payment_methods' => 'array',
            'delivery_methods' => 'array',
            'address' => 'array',
            'phone' => 'array'
        ];
    }

    public function getAddresses(): Collection
    {
        return collect($this->address ?? []);
    }

    public function getPhones(): Collection
    {
        return collect($this->phone ?? []);
    }

    
}
