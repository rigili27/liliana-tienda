<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Services\SearchService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{

    use WithPagination;

    private $products;

    public $families, $categories;

    public $order, $family, $category; // Para filtros de busqueda

    public $b, $temp_b; // para buscar
    protected $queryString = ['b']; // Persistir búsqueda y orden en la URL

    public function mount()
    {
        $this->order = Cache::get('product_order', null);
        $this->family = Cache::get('family_filter', null);
        $this->category = Cache::get('category_filter', null);

        $this->families = Family::getFamilies();
        $this->categories = Category::getCategories();

        $this->temp_b = '';
    }

    public function render(SearchService $searchService)
    {
        // $this->products = Product::paginate(15);
        $this->buscar($searchService);

        return view('livewire.catalog', [
            'products' => $this->products,
        ]);
    }

    public function buscar(SearchService $searchService)
    {
        $filters = [
            'family' => $this->family,
            'category' => $this->category,
        ];

        $this->products = $searchService->searchProducts($filters, $this->b, $this->order);
    }

    public function btnSearchEnter()
    {
        Cache::put('temp_b', $this->temp_b, 10);
        return redirect()->route('catalog', ['b' => $this->temp_b]);
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

    
    // para que wire loading funcione correctamente
    
    public $isPaginating = false;

    public function updatedTempB()
    {
        $this->isPaginating = false; // Cuando se busca, no queremos mostrar el loader
        $this->btnSearchEnter();
    }

    public function pagination()
    {
        $this->isPaginating = true; // Cuando se pagina, activamos el loader
    }
}
