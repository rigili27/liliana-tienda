<a href="{{ route('show-product', $product->id) }}">
    <div {{ $attributes->merge(['class' => 'bg-white border rounded-xl shadow-sm flex .sm:flex dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70']) }}>
        <div class="shrink-0 relative w-full rounded-t-xl overflow-hidden min-h-72 sm:rounded-s-xl max-w-32 .sm:max-w-60 md:rounded-se-none md:max-w-52 .md:max-w-xs">
            {{-- <img class="size-full absolute top-0 start-0 object-cover" src="https://la27ferreteria.com.ar/storage/files/shares/ficha c cable.jpg" alt="Card Image"> --}}

            @if (is_array($product->image_url) && count($product->image_url))
                @foreach ($product->image_url as $image)
                    <img class="size-full absolute top-0 start-0 object-contain .md:object-cover mb-2" src="{{ asset('storage') }}/{{ $image }}" alt="Card Image" loading="lazy">
                @endforeach
            @else
                <p class="text-center text-gray-500">No hay imágenes disponibles.</p>
            @endif

        </div>
        <div class="flex flex-wrap">
            <div class="p-4 flex flex-col h-full sm:p-7">
                <p class="text-gray-500 dark:text-neutral-400">Código interno: {{ $product->id }} | SKU: {{ $product->sku }}</p>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $product->name }}</h3>
                {{-- <h3 class="text-sm font-bold text-blue-800 dark:text-white">
                    <span>{{ $product->family->name }}</span><span class="mx-2">-</span><span>{{ $product->category->name }}</span>
                </h3> --}}
                <p class="m-1 mb-4 line-clamp-4 text-gray-500 dark:text-neutral-400">{!! $product->description !!}</p>
                <div class="mt-5 sm:mt-auto">
                    <p class="text-2xl font-bold text-black">
                        $ {{ number_format(round($product->choosePriceToUserPriceList($product)), 0, ',', '.') }}
                    </p>

                    <div class="my-2"></div>

                    <x-badge class="{{ $product->stock < 1 ? 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500' : 'bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500' }}">
                        {{ $product->stock < 1 ? 'sin stock' : 'stock: ' . $product->stock . ' u.' }}
                    </x-badge>

                    @if (auth()->user())
                        @if ($product->stock > 0)
                            <div class="flex gap-2 mt-4">
                                <x-text-input class="w-32" type="number" min="1" max="{{ $product->stock }}" value="1" id="quantity-{{ $product->id }}" onclick="event.preventDefault();" />
                                <x-preline-button wire:click="addToCartBtn({{ $product->id }}, document.getElementById('quantity-{{ $product->id }}').value)" onclick="event.preventDefault();" class="py-2 px-3 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                                    Agregar al carrito
                                </x-preline-button>
                            </div>
                        @endif
                    @endif

                    <div class="mt-3">
                        <p class="text-gray-500 text-sm dark:text-neutral-400">Actualizado el {{ $product->updated_at?->format('d/m/Y \a \l\a\s H:i') }}hs.</p>
                    </div>

                    {{-- <div>
                        @foreach ($product->attributes as $attribute)
                            {{ $attribute->attribute->show_name }}
                        @endforeach
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</a>
