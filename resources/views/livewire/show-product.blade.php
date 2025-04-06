<div class="">

    <x-navbar :products="$list_products" />

    <div class="container mx-auto py-10">


        <div class="my-5"></div>

        <div class=".max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded-md p-8">
            <div class="grid md:grid-cols-2 gap-4 md:gap-8 xl:gap-20 .md:items-center">

                <div class="relative ms-4">
                    <x-show-product.slider :product="$product" />
                </div>

                <div>
                    <h3 class="text-sm font-bold text-blue-800 dark:text-white">
                        <span>{{ $product->family->name }}</span><span class="mx-2">-</span><span>{{ $product->category->name }}</span>
                    </h3>
                    <p class="mt-3 text-lg text-gray-500 dark:text-neutral-400">Código interno: {{  $product->id }} | SKU: {{ $product->sku }}</p>

                    <h1 class="block text-3xl font-bold text-gray-800 lg:leading-tight dark:text-white">{{ $product->name }}</h1>

                    <div class="flex gap-8 mt-5">
                        <p class="text-3xl font-bold text-black">
                            {{-- $ {{ $product->choosePriceToUserPriceList($product) }} --}}
                            $ {{ number_format(round($product->choosePriceToUserPriceList($product)), 0, ',', '.') }}
                        </p>
                        <p class="border-r border-gray-400"></p>
                        <x-badge class="{{ $product->stock < 1 ? 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500' : 'bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500' }}">
                            {{ $product->stock < 1 ? 'sin stock' : 'stock: ' . $product->stock . ' u.' }}
                        </x-badge>
                    </div>
                    <div class="my-8"></div>
                    <p class="mt-3 text-lg text-gray-800 dark:text-neutral-400">{!! $product->description !!}</p>

                    @if (auth()->user())
                        @if ($product->stock > 0)
                            <div class="flex gap-2 mt-4">
                                <x-text-input class="w-32" type="number" min="1" max="{{ $product->stock }}" value="1" id="quantity-{{ $product->id }}" />
                                <x-preline-button wire:click="addToCartBtn({{ $product->id }}, document.getElementById('quantity-{{ $product->id }}').value)" onclick="event.preventDefault();" class="py-3 px-4 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                                    Agregar al carrito
                                </x-preline-button>
                            </div>
                        @endif
                    @endif

                    <div class="mt-3">
                        <p class="text-gray-500 text-sm dark:text-neutral-400">Actualizado el {{ $product->updated_at?->format('d/m/Y \a \l\a\s H:i') }}hs.</p>
                    </div>

                </div>
            </div>
        </div>





    </div>


</div>
