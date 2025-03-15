<div>
    <h2 class="text-xl font-bold">Carrito</h2>

    @if(empty($cart))
        <p>No hay productos en el carrito.</p>
    @else
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border p-2">Producto</th>
                    <th class="border p-2">Precio</th>
                    <th class="border p-2">Cantidad</th>
                    <th class="border p-2">Total</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                    <tr>
                        <td class="border p-2">{{ $item['name'] }}</td>
                        <td class="border p-2">{{ $item['price'] }}</td>
                        <td class="border p-2">
                            <input type="number" class="w-16" min="1" wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)" value="{{ $item['quantity'] }}">
                        </td>
                        <td class="border p-2">{{ $item['price'] * $item['quantity'] }}</td>
                        <td class="border p-2">
                            <button class="text-red-500" wire:click="removeFromCart({{ $item['id'] }})">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <x-preline-button wire:click="clearCart" class="bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:bg-red-600">Vaciar carrito</x-preline-button>
        </div>

        <div class="mt-4">
            <x-preline-button wire:click="confirmCart" class="bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:bg-teal-600">Confirmar orden</x-preline-button>
        </div>

        
    @endif
</div>
