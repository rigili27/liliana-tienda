<div>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 .mx-auto .w-[70vw] h-[30vh] mt-1 gap-4 .bg-red-200">

            <div class="h-[30vh]">

                <!-- Slider -->
                <div data-hs-carousel='{"loadingClasses": "opacity-0","dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-blue-500 dark:hs-carousel-active:border-blue-500","isAutoPlay": true}' class="relative">
                    <div class="hs-carousel relative overflow-hidden w-full h-[30vh] bg-white .rounded-md shadow-md">
                        <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                            @foreach ($heros as $hero)
                                <div class="hs-carousel-slide">
                                    <img src="{{ asset('storage') }}/{{ $hero->image_url }}" alt="{{ $hero->name }}" class="w-full h-full object-cover .rounded-md">
                                </div>
                            @endforeach
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

                    <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 flex gap-x-2"></div>
                </div>
                <!-- End Slider -->

            </div>

        </div>
    </div>
</div>
