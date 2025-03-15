<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'fecha',
        'fechavto',
        'tipomov',
        'talonario',
        'nrocomprobante',
        'codadminis',
        'condvta',
        'user_id',
        'nombre',
        'nrocuit',
        'codcativa',
        'domicilio',
        'codlocalidad',
        'tipoprecios',
        'nrolispre',
        'neto1',
        'poriva1',
        'impiva1',
        'neto2',
        'poriva2',
        'impiva2',
        'neto3',
        'poriva3',
        'impiva3',
        'impiinterno',
        'retganancias',
        'retiva',
        'retibruto',
        'percepciones',
        'sellado',
        'totalgral',
        'totchqcar',
        'totefectivo',
        'tottransferencia',
        'totcanje',
        'marcacont',
        'marcaestado',
        'ventaanticipada',
        'nota',
        'cotizdolar',
        'novaaliva',
        'notamovimiento',
        'marcafcanje',
        'idivacanje',
        'numerorto',
        'coddeposito',
        'dolar',
        'marcaanulado',
        'nrocae',
        'fechacae',
        'letrafactura',
        'idCobranza',
        'imagen',
        'movsart',
        'marcarval',
        'idrecvalores',
        'attach',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
