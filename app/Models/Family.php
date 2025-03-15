<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    // protected $guarded = [];

    protected $fillable = [
        'id',
        'name',
        'image_url',
        'position'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public static function getFamilies(){
        return Family::has('products')->orderBy('name')->get();
    }

    public static function getFamiliesWithImage($quantity = '', $order = 'asc') {
        $families = Family::query()
            ->with(['products' => function ($query) {
                $query->select('id', 'family_id', 'image_url')->whereNotNull('image_url');
            }])
            ->orderBy('name', $order);
    
        if ($quantity != '') {
            $families = $families->take($quantity);
        }
    
        return $families->get()->map(function ($family) {
            $productImage = $family->products->first()?->image_url;
            return [
                'id' => $family->id,
                'name' => $family->name,
                'image_url' => $family->image_url,
                'product_image' => is_array($productImage) ? $productImage[0] : null, // Selecciona la primera imagen del producto.
            ];
        });
    }
    
}
