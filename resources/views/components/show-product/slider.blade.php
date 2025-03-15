<div>
    <!-- Slider -->
    <div data-hs-carousel='{
        "loadingClasses": "opacity-0"
    }' class="relative">
        <div class="hs-carousel flex space-x-2">
            <div class="flex-none">
                <div class="hs-carousel-pagination max-h-[40rem] flex flex-col gap-y-2 overflow-y-auto">

                    @if(is_array($product->image_url) && count($product->image_url))
                        @foreach($product->image_url as $image)
                        <div class="hs-carousel-pagination-item shrink-0 border rounded-md overflow-hidden cursor-pointer w-[150px] h-[150px] hs-carousel-active:border-blue-400">
                            <div class="flex justify-center h-full bg-gray-200 p.-6 dark:bg-neutral-800">
                            <img class="size-full .absolute top-0 start-0 object-cover mb-2" src="{{ asset('storage') }}/{{ $image }}" loading="lazy">
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="hs-carousel-pagination-item shrink-0 border rounded-md overflow-hidden cursor-pointer w-[150px] h-[150px] hs-carousel-active:border-blue-400">
                            <div class="flex justify-center h-full bg-gray-200 p-6 dark:bg-neutral-800">
                            <span class="self-center text-4xl text-gray-800 transition duration-700 dark:text-white">No img</span>
                            </div>
                        </div>
                    @endif 

                    {{-- <div class="hs-carousel-pagination-item shrink-0 border rounded-md overflow-hidden cursor-pointer w-[150px] h-[150px] hs-carousel-active:border-blue-400">
                        <div class="flex justify-center h-full bg-gray-100 p-2 dark:bg-neutral-900">
                            <span class="self-center text-xs text-gray-800 transition duration-700 dark:text-white">First slide</span>
                        </div>
                    </div> --}}
                    
                </div>
            </div>

            <div class="relative grow overflow-hidden min-h-[28rem] bg-white rounded-lg">
                <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0"  wire:ignore>
                    @if(is_array($product->image_url) && count($product->image_url))
                        @foreach($product->image_url as $image)
                        <div class="hs-carousel-slide">
                            <div class="flex justify-center h-full bg-gray-200 p.-6 dark:bg-neutral-800">
                            <img class="size-full .absolute top-0 start-0 object-cover mb-2" src="{{ asset('storage') }}/{{ $image }}" loading="lazy">
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="hs-carousel-slide">
                            <div class="flex justify-center h-full bg-gray-200 p-6 dark:bg-neutral-800">
                            <span class="self-center text-4xl text-gray-800 transition duration-700 dark:text-white">No img</span>
                            </div>
                        </div>
                    @endif 
                </div>

                <button type="button" class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-s-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                    <span class="text-2xl" aria-hidden="true">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    </span>
                    <span class="sr-only">Previous</span>
                </button>
                <button type="button" class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-e-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                    <span class="sr-only">Next</span>
                    <span class="text-2xl" aria-hidden="true">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <!-- End Slider -->
</div>