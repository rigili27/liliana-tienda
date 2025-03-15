<div>
    <h3>hola</h3>

    <x-home.slider-hero :heros="$heros" />

    <div class="absolute top-[55vh] w-[90vw] mx-[5vw] ">

        {{-- horarios --}}
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center p-6 bg-white rounded-lg shadow-md dark:bg-neutral-900">
                    <div class="w-12 h-12 flex-shrink-0 text-blue-600 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3c0 6-6 9-9 9S3 18 3 12 6 3 12 3s9 3 9 9z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-800 dark:text-white font-semibold">Lunes a Viernes</p>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">8:00 AM - 6:00 PM</p>
                    </div>
                </div>
                <div class="flex items-center p-6 bg-white rounded-lg shadow-md dark:bg-neutral-900">
                    <div class="w-12 h-12 flex-shrink-0 text-blue-600 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16-10a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-800 dark:text-white font-semibold">Sábados</p>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">9:00 AM - 1:00 PM</p>
                    </div>
                </div>
                <div class="flex items-center p-6 bg-white rounded-lg shadow-md dark:bg-neutral-900">
                    <div class="w-12 h-12 flex-shrink-0 text-blue-600 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h11M9 21l3-11m4 4h6" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-800 dark:text-white font-semibold">Teléfono</p>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">+54 9 123 456 789</p>
                    </div>
                </div>
            </div>
        </div>

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
    </div>

</div>
