<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    public static function getCategories(){
        return Category::has('products')->orderBy('name')->get();
    }
}
