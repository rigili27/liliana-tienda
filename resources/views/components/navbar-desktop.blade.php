<div>

    <div class="bg-white shadow-md dark:bg-neutral-800">
        <div class="container mx-auto flex items-center justify-between py-4 px-6">
            <img class="inline-block .size-8 " src="/assets/images/logo.png" alt="La 27 ferretería">
            {{-- <p>{{ $business->name }}</p> --}}
            <div class="relative .w-full .max-w-lg w-[60%]">
                <div id="hs-combobox-basic-usage" class="relative" data-hs-combo-box="">
                    <div class="relative">
                        <input wire:model.defer="temp_b" wire:keydown.enter="btnSearchEnter" class="py-3 ps-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="¿Qué estás buscando?" type="text" role="combobox" aria-expanded="false" value="" data-hs-combo-box-input="">
                        <div class="absolute top-1/2 end-3 -translate-y-1/2" aria-expanded="false" data-hs-combo-box-toggle=""></div>
                    </div>
                    <div class="absolute z-50 w-full max-h-72 p-1 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700" style="display: none;" data-hs-combo-box-output="">

                        {{-- @foreach ($products as $item)
                            <a href="{{ route('show-product', $item->id) }}" class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800" tabindex="0" data-hs-combo-box-output-item="">
                                <div class="flex justify-between items-center w-full">
                                    <span data-hs-combo-box-search-text="{{ $item->name }}" data-hs-combo-box-value="">{{ $item->name }}</span>
                                </div>
                            </a>
                        @endforeach --}}

                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                @if (auth()->user())
                    {{--  <x-preline-button class="py-2 px-3 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700" aria-haspopup="dialog" aria-expanded="false" aria-controls="cart-modal" data-hs-overlay="#cart-modal">
                        Carrito
                    </x-preline-button> --}}
                    <a href="#" aria-haspopup="dialog" aria-expanded="false" aria-controls="cart-modal" data-hs-overlay="#cart-modal" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        Carrito
                    </a>
                    <a href="{{ env('APP_URL') }}/admin/web-orders" target="_blank" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                        Mis pedidos
                    </a>
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ env('APP_URL') }}/admin/" target="_blank" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                            Administrador
                        </a>
                    @endif
                @else
                    <a href="{{ env('APP_URL') }}/admin/" target="_blank" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                        Iniciar sesión
                    </a>
                @endif

            </div>

        </div>
    </div>

    <x-preline-modal>
        <livewire:cart />
    </x-preline-modal>


    {{-- <div class="mx-auto w-[60%] mt-5">

        <div class="bg-yellow-50 border border-yellow-200 text-lg text-yellow-800 rounded-lg p-4 dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500" role="alert" tabindex="-1" aria-labelledby="hs-with-description-label">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="shrink-0 size-5 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                    </svg>
                </div>
                <div class="ms-4">
                    <h3 id="hs-with-description-label" class="text-lg font-semibold">
                        Atención
                    </h3>
                    <div class="mt-1 text-lg text-yellow-700">
                        Nuestra página se encuenta en remodelación. Cualquier información o movimiento que se plasme son exclusivamente de pruebas internas, y no son reales.
                    </div>
                    
                </div>
            </div>
        </div>
    </div> --}}

</div>
