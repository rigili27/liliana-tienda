<div>

    <!-- Slider -->
    <div data-hs-carousel='{
    "loadingClasses": "opacity-0",
    "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-blue-500 dark:hs-carousel-active:border-blue-500",
    "slidesQty": {
      "xs": 1,
      "lg": 4
    }
  }' class="relative">
        <div class="hs-carousel w-full overflow-hidden rounded-lg dark:bg-neutral-900 ">
            <div class="relative -mx-1 h-[50vh]">
                <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap opacity-0 transition-transform duration-700 gap-4">

                    @foreach ($products as $product)
                        <div class="hs-carousel-slide">
                            <div class="flex flex-col bg-white border border-gray-200 shadow-lg rounded-xl">
                                @if (is_array($product->image_url) && count($product->image_url))
                                    @foreach ($product->image_url as $image)
                                        <img class="h-[25vh] rounded-t-xl object-contain" src="{{ asset('storage') }}/{{ $image }}" alt="Card Image" loading="lazy">
                                    @endforeach
                                @else
                                    <p class="h-[25vh] text-center text-gray-500">No hay imágenes disponibles.</p>
                                @endif
                                <div class="p-4 md:p-5 h-[20vh]">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white line-clamp-2">
                                        {{ $product->name }}
                                    </h3>
                                    <h3 class="text-2xl font-semibold text-gray-500 dark:text-neutral-500">
                                        $ {{ $product->choosePriceToUserPriceList($product) }}
                                    </h3>
                                    <p class="mt-1 text-gray-500 dark:text-neutral-400 line-clamp-2">
                                        {{ $product->description }}
                                    </p>
                                    {{-- @if (auth()->user())
                                        @if ($product->stock > 0)
                                            <div class="flex gap-2 mt-4">
                                                <x-text-input class="w-32" type="number" min="1" max="{{ $product->stock }}" value="1" id="quantity-{{ $product->id }}" onclick="event.preventDefault();" />
                                                <x-preline-button wire:click="addToCartBtn({{ $product->id }}, document.getElementById('quantity-{{ $product->id }}').value)" onclick="event.preventDefault();" class="py-2 px-3 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                                                    Agregar al carrito
                                                </x-preline-button>
                                            </div>
                                        @endif
                                    @endif --}}

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <button type="button" class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-s-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
            <span class="text-2xl" aria-hidden="true">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
            </span>
            <span class="sr-only">Previous</span>
        </button>
        <button type="button" class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-e-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
            <span class="sr-only">Next</span>
            <span class="text-2xl" aria-hidden="true">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            </span>
        </button>

        <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 gap-x-2"></div>
    </div>
    <!-- End Slider -->


</div>
