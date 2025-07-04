<?php

namespace App\Services;

use App\Models\Family;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class SearchService
{
    public function searchProducts($filters, $searchTerm = null, $order = null, $product_attributes = [])
    {
        $productsQuery = Product::query()->with(['family', 'category']);

        // Aplicar ProductAttributes JSON
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

        // Forzar minúsculas y remover acentos en el término de búsqueda
        $normalizedSearchTerm = is_string($searchTerm) ? $this->normalizeText(trim($searchTerm)) : $searchTerm;

        // Si no hay término de búsqueda, aplicar orden por defecto o el especificado
        if (empty($normalizedSearchTerm)) {
            if ($order === 'asc') {
                $productsQuery->orderBy('price_2', 'asc');
            } elseif ($order === 'desc') {
                $productsQuery->orderBy('price_2', 'desc');
            } elseif ($order === 'name') {
                $productsQuery->orderBy('name', 'asc');
            } else {
                $productsQuery->orderBy(
                    Family::select('name')->whereColumn('families.id', 'products.family_id')
                )->orderBy('name', 'asc');
            }

            return $productsQuery->paginate(10);
        }

        // Obtener todos los productos
        $products = $productsQuery->orderBy('name')->get();

        // Coincidencias exactas en id, name o sku o description
        $exactMatches = $products->filter(function ($product) use ($normalizedSearchTerm) {
            return (
                stripos($this->normalizeText($product->name), $normalizedSearchTerm) !== false ||
                stripos($this->normalizeText($product->sku), $normalizedSearchTerm) !== false ||
                stripos($this->normalizeText($product->description ?? ''), $normalizedSearchTerm) !== false ||
                (is_numeric($normalizedSearchTerm) && $product->id == $normalizedSearchTerm)
            );
        });
        
        if ($exactMatches->isNotEmpty()) {
            $sortedExactMatches = $exactMatches->sortBy(function ($product) use ($normalizedSearchTerm) {
                $namePosition = stripos($this->normalizeText($product->name), $normalizedSearchTerm);
                $skuPosition = stripos($this->normalizeText($product->sku), $normalizedSearchTerm);
                $idMatch = (is_numeric($normalizedSearchTerm) && $product->id == $normalizedSearchTerm) ? 0 : PHP_INT_MAX;

                return min($idMatch, $namePosition !== false ? $namePosition : PHP_INT_MAX, $skuPosition !== false ? $skuPosition : PHP_INT_MAX);
            });

            if ($order === 'asc') {
                $sortedExactMatches = $sortedExactMatches->sortBy('price_2');
            } elseif ($order === 'desc') {
                $sortedExactMatches = $sortedExactMatches->sortByDesc('price_2');
            } elseif ($order === 'name') {
                $sortedExactMatches = $sortedExactMatches->sortBy('name');
            }


            return $this->paginateCollection($sortedExactMatches, 10);
        }


        // Coincidencias similares
        $similarMatches = $products->map(function ($product) use ($normalizedSearchTerm) {
            $name = $this->normalizeText($product->name);
            $sku = $this->normalizeText($product->sku);
            $desc = $this->normalizeText($product->description ?? '');

            similar_text($normalizedSearchTerm, $name, $namePercentMatch);
            similar_text($normalizedSearchTerm, $sku, $skuPercentMatch);
            similar_text($normalizedSearchTerm, $desc, $descPercentMatch);

            return [
                'product' => $product,
                'nameSimilarity' => $namePercentMatch,
                'skuSimilarity' => $skuPercentMatch,
                'descSimilarity' => $descPercentMatch,
                'maxSimilarity' => max($namePercentMatch, $skuPercentMatch, $descPercentMatch),
            ];
        })->filter(function ($item) {
            return $item['maxSimilarity'] > 6;
        });

        if ($similarMatches->isNotEmpty()) {
            $sortedSimilarMatches = $similarMatches->sortByDesc('maxSimilarity')->pluck('product');

            if ($order === 'asc') {
                $sortedSimilarMatches = $sortedSimilarMatches->sortBy('price_2');
            } elseif ($order === 'desc') {
                $sortedSimilarMatches = $sortedSimilarMatches->sortByDesc('price_2');
            } elseif ($order === 'name') {
                $sortedSimilarMatches = $sortedSimilarMatches->sortBy('name');
            }

            return $this->paginateCollection($sortedSimilarMatches, 10);
        }

        return $this->paginateCollection(collect([]), 10);
    }

    /**
     * Paginación manual
     */
    public function paginateCollection($collection, $perPage = 10)
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

    /**
     * Normaliza texto: minúsculas y sin acentos
     */
    private function normalizeText($text)
    {
        $text = mb_strtolower($text);

        $normalizeChars = [
            'á' => 'a', 'é' => 'e', 'í' => 'i',
            'ó' => 'o', 'ú' => 'u', 'ü' => 'u',
            'ñ' => 'n',
        ];

        return strtr($text, $normalizeChars);
    }
}
