<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use App\Models\Product;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class Cart extends Component
{
    public $cart = [];

    // protected $listeners = ['agregar' => 'addToCart'];

    public function mount()
    {
        $this->cart = session()->get('cart', []); // Inicializa el carrito desde la sesión
    }

    #[On('addToCart')] 
    public function addToCart($productId, $quantity = 1)
    {
        Log::info('add');
        $product = Product::findOrFail($productId);

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] += $quantity; // Incrementa la cantidad si ya existe
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price_1,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $this->cart); // Guarda en la sesión

        Notification::make()
            ->title('Saved successfully')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();
    }

    public function updateQuantity($productId, $quantity)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] = max(1, $quantity); // Asegura que la cantidad sea al menos 1
            session()->put('cart', $this->cart);
        }
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            session()->put('cart', $this->cart);
        }
    }

    public function clearCart()
    {
        $this->cart = [];
        session()->forget('cart');
    }

    public function render()
    {
        return view('livewire.cart', ['cart' => $this->cart]);
    }

    public function confirmCart()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'El carrito está vacío.');
            return;
        }

        // Crear la orden
        $order = Order::create([
            'user_id' => Auth::id(),
            'prefix' => '0001', // Ejemplo, puedes cambiarlo según tu lógica
            'number' => rand(1000, 9999), // Generar número de orden único
            'date' => now(),
            'user_name' => Auth::user()->name ?? 'Cliente Anónimo',
            'user_address' => Auth::user()->address ?? 'Sin dirección',
            'total' => $this->calculateTotal(),
        ]);

        // Crear los ítems de la orden
        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'description' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'importe' => $item['price'] * $item['quantity'],
            ]);
        }

        // Limpiar el carrito
        $this->clearCart();

        session()->flash('success', 'La orden se ha confirmado exitosamente.');
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }


}
