<?php

namespace App\Livewire;

use App\Http\Livewire\Cart;
use App\Models\Business;
use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Services\SearchService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithPagination;

use ProtoneMedia\LaravelCrossEloquentSearch\Search;

use function Illuminate\Log\log;

class Catalog extends Component
{
    use WithPagination;

    public $business;

    private $products;

    public $families, $categories;

    public $b, $temp_b; // para buscar

    public $order, $family, $category; // Para filtros de busqueda

    public $list_products;

    protected $queryString = ['b', 'order', 'family', 'category']; // Persistir búsqueda y orden en la URL

    public function mount(){

        $this->business = Business::first();

        $this->order = Cache::get('product_order', null);
        $this->family = Cache::get('family_filter', null);
        $this->category = Cache::get('category_filter', null);

        $this->families = Family::getFamilies();
        $this->categories = Category::getCategories();
        
        
        // para la barra de search
        $this->list_products = Product::all();
        
        $this->temp_b = '';
    }

    public function btnSearchEnter(){
        Cache::put('temp_b', $this->temp_b);
        return redirect()->route('catalog', ['b' => $this->temp_b]);
    }

    public function buscar(SearchService $searchService)
    {
        $filters = [
            'family' => $this->family,
            'category' => $this->category,
        ];

        $this->products = $searchService->searchProducts($filters, $this->b, $this->order);
    }

    public function render(SearchService $searchService)
    {

        $this->buscar($searchService);

        return view('livewire.catalog', [
            'products' => $this->products,
        ]);
    }

    public function changeOrder($order)
    {
        $this->order = $order;
        Cache::put('product_order', $this->order, 60); // Guardar por 60 minutos
        $this->resetPage(); // Reiniciar la paginación al cambiar el orden
    }

    public function changeFilterFamily($id)
    {
        $this->family = $id;
        Cache::put('family_filter', $this->family, 60);
        $this->resetPage();
    }

    public function changeFilterCategory($id)
    {
        $this->category = $id;
        Cache::put('category_filter', $this->category, 60);
        $this->resetPage();
    }

    public function changeFilterB()
    {
        $this->temp_b = '';
        $this->b = '';
        Cache::delete('temp_b');
        $this->resetPage();
    }

    public function addToCartBtn($product, $quantity)
    {
        if($quantity<1)
            $quantity = 1;

        $this->dispatch('addToCart', productId: $product, quantity: $quantity)->to(\App\Livewire\Cart::class);
    }


}
