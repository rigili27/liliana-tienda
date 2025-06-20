<?php

namespace App\Livewire;

use App\Models\Attribute;
use App\Models\Business;
use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Services\SearchService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

use function Illuminate\Log\log;

class Catalog extends Component
{
    use WithPagination;

    public $business;

    private $products;

    public $families, $categories;

    public $list_attributes, $attr;

    public $b, $temp_b; // para buscar

    public $order, $family, $category; // Para filtros de busqueda

    public $list_products;


    protected $queryString = ['b', 'order', 'family', 'category', 'attr']; // Persistir búsqueda y orden en la URL

    public function mount()
    {

        $this->business = Business::first();


        // $this->order = Cache::get('product_order', null);
        $this->order = Cache::get($this->cacheKey('product_order'), null);

        // $this->family = Cache::get('family_filter', null);
        $this->family = Cache::get($this->cacheKey('family_filter'), null);
        
        // $this->category = Cache::get('category_filter', null);
        $this->category = Cache::get($this->cacheKey('category_filter'), null);

        
        $this->list_attributes = Attribute::has('products')->get();
        
        
        // $this->attr = Cache::get('attr', null);
        $this->attr = Cache::get($this->cacheKey('attr'), null);


        $this->families = Family::getFamilies();
        $this->categories = Category::getCategories();


        // para la barra de search
        $this->list_products = Product::all();

        // $this->temp_b = '';
        $this->b = Cache::get($this->cacheKey('b'), '');
    }

    private function cacheKey($key)
    {
        $prefix = auth()->check() ? 'user_' . auth()->id() : 'session_' . session()->getId();
        return "{$key}_{$prefix}";
    }



    public function btnSearchEnter()
    {
        // Cache::put('temp_b', $this->temp_b);
        Cache::put($this->cacheKey('b'), $this->temp_b);
        return redirect()->route('catalog', ['b' => $this->temp_b]);
    }

    public function buscar(SearchService $searchService)
    {
        $filters = [
            'family' => $this->family,
            'category' => $this->category,
        ];

        if ($this->attr != null)
            $product_attributes = [$this->attr];
        else
            $product_attributes = [];

        $this->products = $searchService->searchProducts($filters, $this->b, $this->order, $product_attributes);
    }

    public function render(SearchService $searchService)
    {

        $this->buscar($searchService);

        return view('livewire.catalog', [
            'products' => $this->products,
        ]);
    }

    public function clearAllFilters()
    {
        $this->order = null;
        // Cache::delete('product_order');
        Cache::delete($this->cacheKey('product_order'));

        $this->family = null;
        // Cache::delete('family_filter');
        Cache::delete($this->cacheKey('family_filter'));

        $this->category = null;
        // Cache::delete('category_filter');
        Cache::delete($this->cacheKey('category_filter'));

        $this->temp_b = '';
        // Cache::delete('temp_b');
        Cache::delete($this->cacheKey('temp_b'));
        $this->b = '';

        $this->attr = null;
        // Cache::delete('attr');
        Cache::delete($this->cacheKey('attr'));

        $this->resetPage();
    }

    public function changeOrder($order)
    {
        $this->order = $order;
        // Cache::put('product_order', $this->order, 60); // Guardar por 60 minutos
        Cache::put($this->cacheKey('product_order'), $this->order, 60); // Guardar por 60 minutos
        $this->resetPage(); // Reiniciar la paginación al cambiar el orden
    }

    public function changeFilterFamily($id)
    {
        $this->family = $id;
        // Cache::put('family_filter', $this->family, 60);
        Cache::put($this->cacheKey('family_filter'), $this->family, 60);
        $this->resetPage();
    }

    public function changeFilterCategory($id)
    {
        $this->category = $id;
        // Cache::put('category_filter', $this->category, 60);
        Cache::put($this->cacheKey('category_filter'), $this->category, 60);
        $this->resetPage();
    }

    public function changeFilterB()
    {
        $this->temp_b = '';
        $this->b = '';
        // Cache::delete('temp_b');
        Cache::delete($this->cacheKey('temp_b'));
        $this->resetPage();
    }

    public function changeFilterAttributes($id)
    {
        if ($id === $this->attr) {
            $this->attr = null;
            // Cache::delete('attr');
            Cache::delete($this->cacheKey('attr'));
        } else {
            $this->attr = $id;
            // Cache::put('attr', $id, 60);
            Cache::put($this->cacheKey('attr'), $id, 60);
        }
    }

    public function addToCartBtn($product, $quantity)
    {
        if ($quantity < 1)
            $quantity = 1;

        $this->dispatch('addToCart', productId: $product, quantity: $quantity)->to(\App\Livewire\Cart::class);
    }

    public function pagination()
    {
        // No hace nada, es solo para activar wire:loading cuando se cambia de página
    }
}
