<div>
    {{-- <div>
        <input type="text" wire:model.defer="temp_b" wire:keydown.enter="btnSearchEnter">
    </div> --}}

    <x-navbar />

    <div class="mt-5"></div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mx-0 md:mx-5">

        <div class="hidden lg:block">

            @if ($attr != '' || $temp_b != '' || $order != '' || $family != '')
                <div class="flex max-w-xs">
                    <span class="text-lg text-red-600 cursor-pointer" wire:click="clearAllFilters()">Borrar todos los filtros</span>
                </div>

                <div class="my-9"></div>
            @endif

            @if ($list_attributes->count() > 0)
                <div class="flex max-w-xs">
                    <p class="flex-1 text-lg font-bold pb-2 text-gray-800 dark:text-white">Atributos</p>
                </div>
                <ul class="max-w-xs flex flex-col">
                    @foreach ($list_attributes as $a)
                        <x-catalog.sidebar.list wire:click="changeFilterAttributes({{ $a->id }})" name="{{ $a->show_name }}" class="{{ Cache::get('attr') === $a->id ? 'text-blue-800' : 'text-gray-800' }} cursor-pointer" />
                    @endforeach
                </ul>

                <div class="my-9"></div>
            @endif


            @if ($b != '')
                <div class=" max-w-xs">
                    <div>
                        <p class="flex text-lg font-bold pb-2 text-gray-800 dark:text-white">Palabra buscada</p>
                    </div>
                    <ul>
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                            {{ $b }}
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

                @if ($order != '')
                    <span class="text-lg text-red-600 cursor-pointer" wire:click="changeOrder('')">Borrar filtro {{ $order }}</span>
                @endif
            </div>
            <ul class="max-w-xs flex flex-col">
                <x-catalog.sidebar.list wire:click="changeOrder('name')" name="Por nombre" class="{{ $order === 'name' ? 'text-blue-800' : 'text-gray-800' }} cursor-pointer" />
                <x-catalog.sidebar.list wire:click="changeOrder('asc')" name="Menor precio" class="{{ $order === 'asc' ? 'text-blue-800' : 'text-gray-800' }} cursor-pointer" />
                <x-catalog.sidebar.list wire:click="changeOrder('desc')" name="Mayor precio" class="{{ $order === 'desc' ? 'text-blue-800' : 'text-gray-800' }} cursor-pointer" />
            </ul>

            <div class="my-9"></div>

            <div class="flex max-w-xs">
                <p class="flex-1 text-lg font-bold pb-2 text-gray-800 dark:text-white">Rubros</p>
                @if ($family != '')
                    <span class="text-lg text-red-600 cursor-pointer" wire:click="changeFilterFamily('')">Borrar filtro</span>
                @endif
            </div>
            <ul class="max-w-xs flex flex-col max-h-96 overflow-y-auto">
                @foreach ($families as $item)
                    <x-catalog.sidebar.list :name="$item->name" wire:click="changeFilterFamily({{ $item->id }})" class="{{ $family === $item->id ? 'text-blue-800' : 'text-gray-800' }} cursor-pointer" />
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
            <div class="my-4" wire:key="pagination" wire:click="pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
