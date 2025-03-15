<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ShowProduct extends Component
{
    public $product;
    public $list_products, $temp_b;

    public function mount($id)
    {
        $this->product = Product::find($id);
        $this->list_products = Product::all();
        $this->temp_b = '';
    }

    public function render()
    {
        return view('livewire.show-product', []);
    }

    public function addToCartBtn($product, $quantity)
    {
        if ($quantity < 1)
            $quantity = 1;

        $this->dispatch('addToCart', productId: $product, quantity: $quantity)->to(\App\Livewire\Cart::class);
    }

    public function btnSearchEnter(){
        Cache::put('temp_b', $this->temp_b);
        return redirect()->route('catalog', ['b' => $this->temp_b]);
    }
}
