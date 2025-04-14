<?php

namespace App\Services;

use App\Models\Family;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class SearchService
{

    // funcion son soundlike funciona correnctamente
    public function searchProducts($filters, $searchTerm = null, $order = null, $product_attributes = [])
    {
        $productsQuery = Product::query()->with(['family', 'category']);

        // Aplicar ProductAttributes JSON
        // if (!empty($filters['new'])) {
        //     $newProducts = ProductAttribute::whereJsonContains('attributes->new', true)->pluck('product_id');
        //     $productsQuery = $productsQuery->whereIn('id', $newProducts);
        // }
        if (!empty($product_attributes)) {
            foreach ($product_attributes as $pa) {
                $productsQuery = $productsQuery->whereHas('attributes', function ($query) use ($pa) {
                    $query->where('attribute_id', $pa);
                });
            }
        }

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
        $products = $productsQuery->orderBy('name')->get();

        // Coincidencias exactas en id, name o sku
        $exactMatches = $products->filter(function ($product) use ($searchTerm) {
            return stripos($product->name, $searchTerm) !== false ||
                stripos($product->sku, $searchTerm) !== false ||
                stripos($product->description, $searchTerm) !== false ||
                (is_numeric($searchTerm) && $product->id == $searchTerm);
        });

        // Si hay coincidencias exactas, devolver solo esas
        if ($exactMatches->isNotEmpty()) {
            $sortedExactMatches = $exactMatches->sortBy(function ($product) use ($searchTerm) {
                $namePosition = stripos($product->name, $searchTerm);
                $skuPosition = stripos($product->sku, $searchTerm);
                $idMatch = (is_numeric($searchTerm) && $product->id == $searchTerm) ? 0 : PHP_INT_MAX;

                // Priorizar `id`, luego `name`, luego `sku`
                Log::info('Si hay coincidencias exactas, devolver solo esas AA');
                return min($idMatch, $namePosition !== false ? $namePosition : PHP_INT_MAX, $skuPosition !== false ? $skuPosition : PHP_INT_MAX);
            });

            Log::info('Si hay coincidencias exactas, devolver solo esas BB');
            return $this->paginateCollection($sortedExactMatches, 10);
        }

        // Coincidencias similares en name o sku (id solo se busca exacto, no es relevante aquí)
        $similarMatches = $products->map(function ($product) use ($searchTerm) {
            $nameSimilarity = similar_text(mb_strtolower($searchTerm), mb_strtolower($product->name), $namePercentMatch);
            $skuSimilarity = similar_text(mb_strtolower($searchTerm), mb_strtolower($product->sku), $skuPercentMatch);
            $descSimilarity = similar_text(mb_strtolower($searchTerm), mb_strtolower($product->description ?? ''), $descPercentMatch);

            return [
                'product' => $product,
                'nameSimilarity' => $nameSimilarity,
                'skuSimilarity' => $skuSimilarity,
                'descSimilarity' => $descSimilarity,
                'maxSimilarity' => max($nameSimilarity, $skuSimilarity),
            ];
        })->filter(function ($item) {
            Log::info('Coincidencias similares en name o sku (id solo se busca exacto, no es relevante aquí)');
            return $item['maxSimilarity'] > 6;
        });

        // Ordenar por similitud y devolver
        if ($similarMatches->isNotEmpty()) {
            $sortedSimilarMatches = $similarMatches->sortByDesc('maxSimilarity')->pluck('product');

            if ($order === 'asc') {
                $sortedSimilarMatches = $sortedSimilarMatches->sortBy('price_1');
            } elseif ($order === 'desc') {
                $sortedSimilarMatches = $sortedSimilarMatches->sortByDesc('price_1');
            } elseif ($order === 'name') {
                $sortedSimilarMatches = $sortedSimilarMatches->sortBy('name');
            }

            Log::info('Ordenar por similitud y devolver AA');
            return $this->paginateCollection($sortedSimilarMatches, 10);
        }

        Log::info('Ordenar por similitud y devolver BBB');
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


    ////










}
