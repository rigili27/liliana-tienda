<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\WebOrderStatus;

class WebOrder extends Model
{
    protected $fillable = ['user_id', 'status', 'date', 'total_price', 'comment'];

    protected $casts = [
        'status' => WebOrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function web_order_items()
    {
        return $this->hasMany(WebOrderItem::class);
    }
}
