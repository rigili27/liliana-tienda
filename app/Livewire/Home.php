<?php

namespace App\Livewire;

use App\Models\Attribute;
use App\Models\Family;
use App\Models\Hero;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\CompanySetting;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Cache;

class Home extends Component
{
    public $heros, $families, $products, $products_by_family, $todaySchedule, $addresses, $phones;

    public $list_attributes, $product_attr, $product_by_attribute;

    public $b, $temp_b; // para buscar

    public function mount()
    {
        $this->heros = Hero::all();
        $this->families = Family::orderBy('name')->get();

        $randomFamilyId = Family::inRandomOrder()->value('id');
        $this->products_by_family = Product::inRandomOrder()
            ->where('family_id', $randomFamilyId)
            ->limit(10)
            ->get();

        $this->products = Product::inRandomOrder()->limit(10)->get();

        $this->list_attributes = Attribute::has('products')->get();

        // buscar por attribute
        $this->product_attr = Product::whereHas('attributes', function ($query) {
            $query->where('attribute_id', 1);
        })->get();


        $this->product_by_attribute = Attribute::whereHas('products')
            ->with(['products' => function ($query) {
                $query->inRandomOrder()->limit(10);
            }])
            ->get();


        // multiples atributos
        // $attributeIds = [1, 2, 3];
        // $products = Product::whereHas('attributes', function ($query) use ($attributeIds) {
        //     $query->whereIn('attribute_id', $attributeIds);
        // })->get();


        $this->getHours();
        $this->getAddress();
        $this->getPhone();
    }

    public function render()
    {
        return view('livewire.home');
    }



    public function getHours()
    {
        $settings = CompanySetting::first();

        $today = strtolower(Carbon::now()->format('l')); // Día de hoy en inglés en minúsculas

        $this->todaySchedule = collect($settings->business_hours)->firstWhere('day', $today);
    }

    public function getAddress()
    {
        $settings = CompanySetting::first();
        $this->addresses = $settings->getAddresses();
    }

    public function getPhone()
    {
        $settings = CompanySetting::first();
        $this->phones = $settings->getPhones();
    }

    private function cacheKey($key)
    {
        $prefix = auth()->check() ? 'user_' . auth()->id() : 'session_' . session()->getId();
        return "{$key}_{$prefix}";
    }

    public function goToCatalog($attr = '', $family = '')
    {

        if ($this->temp_b == ''){
            Cache::delete($this->cacheKey('b'));

        }else{
            Cache::put($this->cacheKey('b'), $this->temp_b);
        }

        if ($attr != '') {
            // Cache::put('attr', $attr, 60);
            Cache::put($this->cacheKey('attr'), $attr, 60);
            return redirect()->route('catalog', ['attr' => $attr]);
        }

        if ($family != '') {
            // Cache::put('family_filter', $family, 60);
            Cache::put($this->cacheKey('family_filter'), $family, 60);
            return redirect()->route('catalog', ['family' => $family]);
        }


        return redirect()->route('catalog');
    }

    public function addToCartBtn($product, $quantity)
    {
        if ($quantity < 1)
            $quantity = 1;

        $this->dispatch('addToCart', productId: $product, quantity: $quantity)->to(\App\Livewire\Cart::class);
    }

    public function btnSearchEnter()
    {
        // Cache::put('temp_b', $this->temp_b);
        if ($this->temp_b == ''){
            Cache::delete($this->cacheKey('b'));

        }else{
            Cache::put($this->cacheKey('b'), $this->temp_b);
        }

        return redirect()->route('catalog', ['b' => $this->temp_b]);
    }
}
