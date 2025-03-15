<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebOrderItem extends Model
{
    protected $fillable = ['web_order_id', 'product_id', 'quantity', 'price', 'importe'];

    public function web_order()
    {
        return $this->belongsTo(WebOrder::class, 'web_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
