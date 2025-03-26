<?php

namespace App\Services;

use App\Models\Family;
use App\Models\Product;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class SearchService
{

    // Mi codigo con multimodel , funciona correctamente
    // public function searchProducts($filters, $searchTerm = null, $order = null)
    // {
    //     $productsQuery = Product::query();

        

    //     if (!empty($filters['family'])) {
    //         $productsQuery = Search::new()
    //             ->add(Product::where('family_id', $filters['family']), ['name', 'sku', 'description', 'family.name', 'category.name']);
    //     }

    //     if (!empty($filters['category'])) {
    //         $productsQuery = Search::new()
    //             ->add(Product::where('category_id', $filters['category']), ['name', 'sku', 'description', 'family.name', 'category.name']);
    //     }

    //     if (!empty($filters['family']) && !empty($filters['category'])) {
    //         $productsQuery = Search::new()
    //             ->add(Product::where('family_id', $filters['family'])->where('category_id', $filters['category']), ['name', 'sku', 'description', 'family.name', 'category.name']);
    //     }

    //     if (empty($filters['family']) && empty($filters['category'])) {
    //         $productsQuery = Search::new()
    //             ->add(Product::class, ['name', 'sku', 'description', 'family.name', 'category.name']);
    //             // ->add(Product::class, ['name', 'sku']);
    //     }

    //     $productsQuery = $productsQuery->beginWithWildcard();

    //     if ($order === 'asc') {
    //         $productsQuery = $productsQuery->orderBy('price_1')->orderByAsc();
    //     } elseif ($order === 'desc') {
    //         $productsQuery = $productsQuery->orderBy('price_1')->orderByDesc();
    //     } elseif ($order === 'name') {
    //         $productsQuery = $productsQuery->orderBy('name')->orderByAsc();
    //     }

    //     return $productsQuery->paginate()
    //         ->search($searchTerm);


        
    // }


    //codigo mejorado sin multimodel, funciona correctamente
    // public function searchProducts($filters, $searchTerm = null, $order = null)
    // {

    //     // Consulta base con filtros iniciales
    //     $productsQuery = Product::query()->with(['family', 'category']);

    //     if (!empty($filters['family'])) {
    //         $productsQuery->where('family_id', $filters['family']);
    //     }

    //     if (!empty($filters['category'])) {
    //         $productsQuery->where('category_id', $filters['category']);
    //     }

    //     if (is_null($searchTerm) || trim($searchTerm) === '') {
    //         // Si no hay término de búsqueda, aplica orden directamente si corresponde
    //         if ($order === 'asc') {
    //             $productsQuery->orderBy('price_1', 'asc');
    //         } elseif ($order === 'desc') {
    //             $productsQuery->orderBy('price_1', 'desc');
    //         } elseif ($order === 'name') {
    //             $productsQuery->orderBy('name', 'asc');
    //         }

    //         return $productsQuery->paginate(10);
    //     }

    //     // Búsqueda inicial
    //     $productsQuery->where(function ($query) use ($searchTerm) {
    //         $query->where('name', 'LIKE', '%' . $searchTerm . '%')
    //             ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
    //             ->orWhere('sku', 'LIKE', '%' . $searchTerm . '%')
    //             ->orWhereHas('family', function ($subQuery) use ($searchTerm) {
    //                 $subQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
    //             })
    //             ->orWhereHas('category', function ($subQuery) use ($searchTerm) {
    //                 $subQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
    //             });
    //     });

    //     // Obtener los resultados
    //     $products = $productsQuery->get();

    //     // Ordenar por posición del término en 'name'
    //     $sortedProducts = $products->sortBy(function ($product) use ($searchTerm) {
    //         $namePosition = stripos($product->name, $searchTerm);

    //         // Si 'name' contiene el término, usamos su posición
    //         if ($namePosition !== false) {
    //             return $namePosition;
    //         }

    //         // Si 'name' no contiene el término, prioridad baja
    //         return PHP_INT_MAX;
    //     });

    //     // Aplicar el orden adicional si se especifica
    //     if ($order === 'asc') {
    //         $sortedProducts = $sortedProducts->sortBy('price_1');
    //     } elseif ($order === 'desc') {
    //         $sortedProducts = $sortedProducts->sortByDesc('price_1');
    //     } elseif ($order === 'name') {
    //         $sortedProducts = $sortedProducts->sortBy('name');
    //     }

    //     // Crear paginación manual
    //     $perPage = 10; // Cantidad de resultados por página
    //     $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Detecta la página actual automáticamente

    //     $paginatedResults = new LengthAwarePaginator(
    //         $sortedProducts->forPage($currentPage, $perPage), // Elementos para la página actual
    //         $sortedProducts->count(), // Total de elementos
    //         $perPage, // Cantidad por página
    //         $currentPage, // Página actual
    //         ['path' => LengthAwarePaginator::resolveCurrentPath()] // Ruta base para la paginación
    //     );

    //     return $paginatedResults;
    // }

    
    // funcion son soundlike funciona correnctamente
    public function searchProducts($filters, $searchTerm = null, $order = null)
    {
        $productsQuery = Product::query()->with(['family', 'category']);

        // Aplicar filtros si están presentes
        if (!empty($filters['family'])) {
            $productsQuery->where('family_id', $filters['family']);
        }

        if (!empty($filters['category'])) {
            $productsQuery->where('category_id', $filters['category']);
        }

        // Si no hay término de búsqueda, aplicar orden por defecto o el especificado
    if (is_null($searchTerm) || trim($searchTerm) === '') {
        if ($order === 'asc') {
            $productsQuery->orderBy('price_1', 'asc');
        } elseif ($order === 'desc') {
            $productsQuery->orderBy('price_1', 'desc');
        } elseif ($order === 'name') {
            $productsQuery->orderBy('name', 'asc');
        } else {
            // Orden por defecto: Family->name y luego Product->name
            $productsQuery->orderBy(
                Family::select('name')->whereColumn('families.id', 'products.family_id')
            )->orderBy('name', 'asc');
        }

        return $productsQuery->paginate(10);
    }

        // Obtener todos los productos
        $products = $productsQuery->get();

        // Coincidencias exactas en name o sku
        $exactMatches = $products->filter(function ($product) use ($searchTerm) {
            return stripos($product->name, $searchTerm) !== false || stripos($product->sku, $searchTerm) !== false;
        });

        // Si hay coincidencias exactas, devolver solo esas
        if ($exactMatches->isNotEmpty()) {
            $sortedExactMatches = $exactMatches->sortBy(function ($product) use ($searchTerm) {
                $namePosition = stripos($product->name, $searchTerm);
                $skuPosition = stripos($product->sku, $searchTerm);

                // Priorizar `name`, pero incluir `sku` como criterio
                return min($namePosition !== false ? $namePosition : PHP_INT_MAX, $skuPosition !== false ? $skuPosition : PHP_INT_MAX);
            });

            return $this->paginateCollection($sortedExactMatches, 10);
        }

        // Coincidencias similares (Levenshtein) en name o sku
        $similarMatches = $products->map(function ($product) use ($searchTerm) {
            $nameSimilarity = similar_text(mb_strtolower($searchTerm), mb_strtolower($product->name), $namePercentMatch);
            $skuSimilarity = similar_text(mb_strtolower($searchTerm), mb_strtolower($product->sku), $skuPercentMatch);

            return [
                'product' => $product,
                'nameSimilarity' => $nameSimilarity,
                'skuSimilarity' => $skuSimilarity,
                'maxSimilarity' => max($nameSimilarity, $skuSimilarity), // Comparar similitud máxima entre ambos campos
            ];
        })->filter(function ($item) {
            return $item['maxSimilarity'] > 6; // Ajustar umbral según necesidad
        });

        // Ordenar por similitud y devolver
        if ($similarMatches->isNotEmpty()) {
            $sortedSimilarMatches = $similarMatches->sortByDesc('maxSimilarity')->pluck('product');

            // Aplicar orden adicional si corresponde
            if ($order === 'asc') {
                $sortedSimilarMatches = $sortedSimilarMatches->sortBy('price_1');
            } elseif ($order === 'desc') {
                $sortedSimilarMatches = $sortedSimilarMatches->sortByDesc('price_1');
            } elseif ($order === 'name') {
                $sortedSimilarMatches = $sortedSimilarMatches->sortBy('name');
            }

            return $this->paginateCollection($sortedSimilarMatches, 10);
        }

        // Si no hay resultados similares, devolver lista vacía
        return $this->paginateCollection(collect([]), 10);
    }

    
    /**
     * Función para crear una paginación manual de una colección.
     */
    function paginateCollection($collection, $perPage = 10)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = $collection->forPage($currentPage, $perPage);
    
        return new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }
    

    





   
}