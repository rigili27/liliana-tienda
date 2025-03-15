<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'entsal',
        'estado',
        'order_id',
        'clavecompras',
        'claveess',
        'clavemed',
        'claverep',
        'coddeposito',
        'codarticulo',
        'descarticulo',
        'precioarticulo',
        'cantidad',
        'importe',
        'poriva',
        'porivani',
        'comentario',
        'fecha',
        'preciocosto',
        'muevestock',
        'genfactura',
        'marcagfa',
        'gfaidfactura',
        'vtaanticipada',
        'cantidadvta',
        'nrocompimp',
        'codcliente',
        'marcaanulado',
        'reserva',
        'idclavepropia',
        'propiedad',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // public function products(){
    //     return $this->hasMany(Product::class);
    // }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
