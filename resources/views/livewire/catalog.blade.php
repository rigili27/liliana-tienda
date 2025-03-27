<div>
    {{-- <div>
        <input type="text" wire:model.defer="temp_b" wire:keydown.enter="btnSearchEnter">
    </div> --}}
    <x-navbar  />

    <div class="mt-5"></div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mx-0 md:mx-5">

        <div class="hidden lg:block">

            @if (Cache::get('temp_b') != '')
                <div class=" max-w-xs">
                    <div>

                        <p class="flex text-lg font-bold pb-2 text-gray-800 dark:text-white">Palabra buscada</p>
                    </div>
                    <ul>
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                            {{ Cache::get('temp_b') }}
                            <button wire:click="changeFilterB('')" type="button" class="shrink-0 size-4 inline-flex items-center justify-center rounded-full hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500 dark:hover:bg-blue-900">
                                <span class="sr-only">Remove badge</span>
                                <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </span>
                    </ul>
                </div>

                <div class="my-9"></div>
            @endif

            <div class="flex max-w-xs">
                <p class="flex-1 text-lg font-bold pb-2 text-gray-800 dark:text-white">Ordenar</p>

                @if (Cache::get('product_order') != '')
                    <span class="text-lg text-red-600 cursor-pointer" wire:click="changeOrder('')">Clear filter</span>
                @endif
            </div>
            <ul class="max-w-xs flex flex-col">
                <x-catalog.sidebar.list wire:click="changeOrder('name')" name="Por nombre" class="{{ Cache::get('product_order') === 'name' ? 'text-blue-800' : 'text-gray-800' }} cursor-pointer" />
                <x-catalog.sidebar.list wire:click="changeOrder('asc')" name="Menor precio" class="{{ Cache::get('product_order') === 'asc' ? 'text-blue-800' : 'text-gray-800' }} cursor-pointer" />
                <x-catalog.sidebar.list wire:click="changeOrder('desc')" name="Mayor precio" class="{{ Cache::get('product_order') === 'desc' ? 'text-blue-800' : 'text-gray-800' }} cursor-pointer" />
            </ul>

            <div class="my-9"></div>

            <div class="flex max-w-xs">
                <p class="flex-1 text-lg font-bold pb-2 text-gray-800 dark:text-white">Families</p>
                @if (Cache::get('family_filter') != '')
                    <span class="text-lg text-red-600 cursor-pointer" wire:click="changeFilterFamily('')">Clear filter</span>
                @endif
            </div>
            <ul class="max-w-xs flex flex-col max-h-96 overflow-y-auto">
                @foreach ($families as $item)
                    <x-catalog.sidebar.list :name="$item->name" wire:click="changeFilterFamily({{ $item->id }})" class="{{ Cache::get('family_filter') === $item->id ? 'text-blue-800' : 'text-gray-800' }} cursor-pointer" />
                @endforeach
            </ul>
        </div>

        <div class="col-span-4">

            <!-- Loader solo cuando se pagina -->
            <div wire:loading wire:target="pagination" class="space-y-4">
                @for ($i = 0; $i < 10; $i++)
                    <div class="h-5 bg-gray-200 animate-pulse rounded-md">
                        cargando...
                    </div>
                @endfor
            </div>

            <!-- Productos -->
            <div wire:loading.remove wire:target="pagination">
                @foreach ($products as $product)
                    <x-catalog.product.horizontal :product="$product" />
                @endforeach
            </div>

            <!-- Paginación con evento -->
            <div wire:key="pagination" wire:click="pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
