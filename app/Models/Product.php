<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    // protected $guarded = [];

    protected $fillable = [
        'id',
        'name',
        'description',
        'family_id',  // rubro
        'category_id',  // sub rubro
        'tags',
        'image_url',
        'stock',
        'off_price',
        'dolar_price',
        'price_1',
        'price_2',
        'price_3',
        'price_m_1',
        'price_m_2',
        'price_m_3',
        'is_off',
        // 'from_date_off',
        // 'to_date_off',
        'is_new',
        'active',
        'sku',
        'bar_code',
        'position'
    ];

    protected $casts = [
        'image_url' => 'array',
    ];

    protected static function booted()
    {
        static::deleted(function (Product $product){
            Log::info("Deleted");
            foreach($product->image_url as $image) {
                Log::info("Deleted -Intentando eliminar: public/$image");
                Storage::disk('public')->delete($image);
            }
        });

        static::updating(function (Product $product) {
            Log::info("Updating");
        
            // Asegúrate de que los valores sean arrays válidos
            $originalImages = $product->getOriginal('image_url') ?? [];
            $currentImages = $product->image_url ?? [];
        
            if (!is_array($originalImages)) {
                $originalImages = json_decode($originalImages, true) ?: [];
            }
        
            if (!is_array($currentImages)) {
                $currentImages = json_decode($currentImages, true) ?: [];
            }
        
            // Determina las imágenes a eliminar
            $imagesToDelete = array_diff($originalImages, $currentImages);
        
            foreach ($imagesToDelete as $image) {
                Log::info("Updating - Intentando eliminar: public/$image");
        
                // Elimina la imagen del disco público
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                    Log::info("Imagen eliminada: public/$image");
                } else {
                    Log::warning("La imagen no existe: public/$image");
                }
            }
        });
        
    }


    // Método para obtener las URLs de las imágenes
    public function getImageUrlAttribute($value)
    {
        return is_array($value) ? $value : json_decode($value, true);
    }

    public function family(){
        return $this->belongsTo(Family::class, 'family_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function getProducts($quantity = '', $order = 'asc', $randomFamily = false, $randomProduct = false, $news=false, $inStock=false)
    {
        $products = Product::query();

        // Solo productos con stock
        if ($inStock){
            $products = $products->where('stock', '>', 0);
        }

        // Solo los productos nuevos
        if ($news) {
            $products = $products->where('is_new', 1);
        }

        // Filtro inicial: productos con precio mayor a 0 y que tengan una imagen
        $products = $products->where('price_1', '>', 0)
                            ->whereNotNull('image_url')
                            ->where('image_url', '!=', '[]');

        // Filtrar por una familia aleatoria
        if ($randomFamily) {
            $randomFamilyId = null;
            $attempts = 0;
            $maxAttempts = 5000; // Límite de intentos

            do {
                $randomFamilyId = Family::has('products')->inRandomOrder()->value('id');
                $attempts++;
            } while ($randomFamilyId < 5 && $attempts < $maxAttempts);

            if ($randomFamilyId) {
                $products = $products->where('family_id', $randomFamilyId);
            }
        }

        // Ordenar productos de manera aleatoria si randomProduct es true
        if ($randomProduct) {
            $products = $products->inRandomOrder();
        } else {
            $products = $products->orderBy('name', $order);
        }

        // Limitar la cantidad de productos devueltos
        if ($quantity != '') {
            $products = $products->take($quantity);
        }

        

        $result = $products->get();

        // Asegurar que todos los productos tengan imagen
        $attempts = 0;
        $maxAttempts = 5000; // Límite de intentos para evitar loops infinitos

        while ($result->contains(function ($product) {
            return empty($product->image_url);
        }) && $attempts < $maxAttempts) {
            $result = $products->get();
            $attempts++;
        }

        // Retornar los productos válidos
        return $result->filter(function ($product) {
            return !empty($product->image_url);
        });
    }

    public static function choosePriceToUserPriceList(Product $product){

        //if(!Auth::user()){
        //    return $product->price_1;
        //}

        //if(Auth::user()->price_list == 1){
        //    return $product->price_1;
        //}
        //if(Auth::user()->price_list == 2){
        //    return $product->price_2;
        //}
        //if(Auth::user()->price_list == 3){
        //    return $product->price_3;
        //}

        return $product->price_2;
    }


}
