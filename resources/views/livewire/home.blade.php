<div>
    <x-navbar />

    <x-home.slider-hero :families="$families" :heros="$heros" />

    <div class="my-9"></div>

    {{-- @if ($todaySchedule)
        <p>Horario de hoy:</p>
        <p>Mañana: {{ $todaySchedule['open'] ?? 'Cerrado' }} - {{ $todaySchedule['close'] ?? 'Cerrado' }}</p>
        <p>Tarde: {{ $todaySchedule['open_afternoon'] ?? 'Cerrado' }} - {{ $todaySchedule['close_afternoon'] ?? 'Cerrado' }}</p>
    @else
        <p>Hoy está cerrado.</p>
    @endif --}}

    <x-home.card-company-setting :todaySchedule="$todaySchedule" :addresses="$addresses" :phones="$phones" />

    <div class="my-14"></div>

    {{-- info --}}
    <div class="container mx-auto mt-9">

        <div class="grid grid-cols-2 gap-6">

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

            <div class="bg-yellow-100 border border-yellow-200 text-yellow-800 rounded-xl shadow-md sm:flex ">
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
            </div>
        </div>


    </div>


    <div class="container mx-auto mt-9">
        <div class="grid grid-cols-4 gap-4">

            @foreach ($products as $product)
                <div class="flex flex-col bg-white border border-gray-200 shadow-md rounded-xl">
                    @if (is_array($product->image_url) && count($product->image_url))
                        @foreach ($product->image_url as $image)
                            <img class="w-full h-auto rounded-t-xl" src="{{ asset('storage') }}/{{ $image }}" alt="Card Image" loading="lazy">
                        @endforeach
                    @else
                        <p class="text-center text-gray-500">No hay imágenes disponibles.</p>
                    @endif
                    <div class="p-4 md:p-5">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white line-clamp-2">
                            {{ $product->name }}
                        </h3>
                        <h3 class="text-2xl font-semibold text-gray-500 dark:text-neutral-500">
                            $ {{ $product->choosePriceToUserPriceList($product) }}
                        </h3>
                        <p class="mt-1 text-gray-500 dark:text-neutral-400">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <a class="mt-2 py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
                            {{ $product->choosePriceToUserPriceList($product) }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
