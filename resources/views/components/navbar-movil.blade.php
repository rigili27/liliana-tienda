<div>
    <header class="relative flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-3 dark:bg-neutral-800">
        <nav class="max-w-[85rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between">
            <div class="flex items-center justify-between">
                <a class="flex-none font-semibold" href="{{ route('home') }}" aria-label="Brand">
                    @php
                        $business = App\Models\Business::first();
                    @endphp
                    <img class="inline-block .size-8 " src="{{ asset('storage') }}/{{ $business->mobile_logo_url }}" alt="La 27 ferretería">
                </a>

                <div class="sm:hidden">
                    <button type="button" class="hs-collapse-toggle relative size-9 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" id="hs-navbar-example-collapse" aria-expanded="false" aria-controls="hs-navbar-example" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-example">
                        <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" x2="21" y1="6" y2="6" />
                            <line x1="3" x2="21" y1="12" y2="12" />
                            <line x1="3" x2="21" y1="18" y2="18" />
                        </svg>
                        <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                </div>
            </div>
            <div id="hs-navbar-example" class="hidden hs-collapse overflow-hidden transition-all duration-300 basis-full grow sm:block" aria-labelledby="hs-navbar-example-collapse">
                <div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">
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
        </nav>
    </header>

    <div class="container mx-auto flex items-center justify-between py-4 px-2">
        <div class="relative .w-full .max-w-lg w-[100%]">
            <div id="hs-combobox-basic-usage" class="relative" data-hs-combo-box="">
                <div class="relative">
                    <form wire:submit.prevent="btnSearchEnter">
                        <input wire:model.defer="temp_b" class="py-3 ps-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="¿Qué estás buscando?" type="text" />
                    </form>
                    {{-- <input wire:model.defer="temp_b" wire:keydown.enter.prevent="btnSearchEnter" class="py-3 ps-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="¿Qué estás buscando?" type="text" role="combobox" aria-expanded="false" value="" data-hs-combo-box-input=""> --}}
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
    </div>
</div>
