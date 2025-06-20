<div>

    <x-navbar />

    <x-home.slider-hero :families="$families" :heros="$heros" :listattributes="$list_attributes" />

    <div class="my-9"></div>

    <div class="mx-2 md:mx-0">
        <x-home.card-company-setting :todaySchedule="$todaySchedule" :addresses="$addresses" :phones="$phones" />
    </div>

    <div class="my-14"></div>

    <div class="mx-2 md:mx-0">

        {{-- info --}}
        <div class="container mx-auto mt-9">

            <div class="grid grid-cols-1 gap-6">

                <div class="bg-red-100 border border-red-200 text-red-800 rounded-xl shadow-md sm:flex ">
                    <div class="shrink-0 relative w-52 rounded-t-xl overflow-hidden .pt-[40%] sm:rounded-s-xl .sm:max-w-60 md:rounded-se-none .md:max-w-xs">
                        <img class="size-full absolute top-0 start-0 object-cover" src="https://www.colegioelatabal.com/wp-content/uploads/2023/05/Trabajando.png" alt="Card Image">
                    </div>
                    <div class="flex flex-wrap">
                        <div class="p-4 flex flex-col h-full sm:p-7">
                            <h3 class="text-2xl font-bold  dark:text-white uppercase">
                                Importante !!
                            </h3>
                            <h3 class="text-lg mt-3 font-normal  dark:text-white uppercase">
                                Te recordamos que los precios de la página pueden tener variaciones.
                            </h3>
                            <h3 class="text-lg mt-3 font-normal t dark:text-white uppercase">
                                Trabajamos contastemente para estar actualizados.
                            </h3>

                        </div>
                    </div>
                </div>

                {{-- <div class="bg-yellow-100 border border-yellow-200 text-yellow-800 rounded-xl shadow-md sm:flex ">
                <div class="shrink-0 relative w-52 rounded-t-xl overflow-hidden .pt-[40%] sm:rounded-s-xl .sm:max-w-60 md:rounded-se-none .md:max-w-xs">
                    <img class="size-full absolute top-0 start-0 object-cover" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-HevEErtoeUbI6MM0GzgBKNYPd4hVTm7Jgg&s" alt="Card Image">
                </div>
                <div class="flex flex-wrap">
                    <div class="p-4 flex flex-col h-full sm:p-7">
                        <h3 class="text-2xl font-bold  dark:text-white uppercase">
                            Nuestro horario
                        </h3>
                        <h3 class="text-lg mt-3 font-normal  dark:text-white ">Lunes a Viernes</h3>
                        <h3 class="text-lg mt-0 font-normal  dark:text-white ">08:00 a 12:00 y 15:30 a 19:30</h3>
                        <h3 class="text-lg mt-3 font-normal t dark:text-white ">Sábados</h3>
                        <h3 class="text-lg mt-0 font-normal  dark:text-white ">08:00 a 12:00 y 15:30 a 17:30</h3>

                    </div>
                </div>
            </div> --}}
            </div>


        </div>

        <div class="my-14"></div>

        @if ($product_by_attribute->count() > 0)
            <div class="container mx-auto">
                @foreach ($product_by_attribute as $attribute)
                    @if ($attribute->products->count() > 0)
                        <div class="flex items-center justify-between my-5">
                            <p class="font-semibold text-lg uppercase">{{ $attribute->show_name }}</p>
                            <span class="text-sm text-blue-600 cursor-pointer hover:underline" wire:click="goToCatalog('{{ $attribute->id }}')">Ver más</span>
                        </div>
                        <x-home.slider-product :products="$attribute->products" />
                    @endif
                @endforeach
            </div>
        @endif

        @if ($products_by_family->count() > 0)
            <div class="container mx-auto">
                <div class="flex items-center justify-between my-5">
                    <p class="font-semibold text-lg uppercase">{{ $products_by_family->first()->family->name }}</p>
                    <span class="text-sm text-blue-600 cursor-pointer hover:underline" wire:click="goToCatalog('', {{ $products_by_family->first()->family->id }})">Ver más</span>
                </div>
                <x-home.slider-product :products="$products_by_family" />
            </div>
        @endif

        @if ($products->count() > 3)
            <div class="container mx-auto">
                <div class="flex items-center justify-between my-5">
                    <p class="font-semibold text-lg uppercase">Algunos productos</p>
                    <span class="text-sm text-blue-600 cursor-pointer hover:underline" wire:click="goToCatalog()">Ver más</span>
                </div>
                <x-home.slider-product :products="$products" />
            </div>
        @endif

    </div>

</div>
