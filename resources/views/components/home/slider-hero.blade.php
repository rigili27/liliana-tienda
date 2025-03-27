<!-- Slider -->
<div data-hs-carousel='{
    "loadingClasses": "opacity-0",
    "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-blue-500 dark:hs-carousel-active:border-blue-500"
  }' class="relative  w-[85vw] mx-auto">
    <div class="hs-carousel relative overflow-hidden w-full h-[60vh] .bg-white .rounded-lg">
        <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
            
			
			@foreach ($heros as $hero)
			<div class="hs-carousel-slide">
				<div class="relative w-full h-[60vh] justify-start">
					<img src="{{ asset('storage') }}/{{ $hero->image_url }}" alt="Imagen" class="w-full h-full object-cover">
					<div class="absolute inset-0 bg-gradient-to-b via-transparent from-transparent to-gray-300"></div>
				</div>
			</div>	
			@endforeach
			
			

            
			{{--
			<div class="hs-carousel-slide">
                <div class="relative flex justify-center bg-gradient-to-b from-green-500 to-transparent dark:bg-neutral-900 h-full">
                    <div class="absolute inset-0 bg-gradient-to-t from-red-300 via-transparent to-transparent"></div>
                    <img src="https://http2.mlstatic.com/D_NQ_861319-MLA80897927976_122024-OO.webp" alt="Imagen con degradado" class="w-full object-cover top">
                    <div class="bg-[url('https://http2.mlstatic.com/D_NQ_861319-MLA80897927976_122024-OO.webp')] w-full bg-top bg-no-repeat">
                    	<div class="inset-0 bg-gradient-to-t from-red-300 via-transparent to-blue-600 h-full absolute"></div>
                    </div>
                </div>
            </div>

            <div class="hs-carousel-slide">
                <div class="relative flex justify-center bg-gradient-to-b from-green-500 to-transparent dark:bg-neutral-900 h-full">
                    <div class="absolute inset-0 bg-gradient-to-t from-red-300 via-transparent to-transparent"></div>
                    <img src="https://media.licdn.com/dms/image/v2/D4D12AQFpm3wavmo7mw/article-cover_image-shrink_600_2000/article-cover_image-shrink_600_2000/0/1699941990687?e=2147483647&v=beta&t=GZLRXBSlpAiDjaCWbLzX_PXwgovU9vY78eQJS0ZrPvY" alt="Imagen con degradado" class="w-full object-cover top">
                    <div class="bg-[url('https://media.licdn.com/dms/image/v2/D4D12AQFpm3wavmo7mw/article-cover_image-shrink_600_2000/article-cover_image-shrink_600_2000/0/1699941990687?e=2147483647&v=beta&t=GZLRXBSlpAiDjaCWbLzX_PXwgovU9vY78eQJS0ZrPvY')] w-full bg-top bg-no-repeat"></div>
                </div>
            </div>

            <div class="hs-carousel-slide">
              <div class="relative flex justify-center bg-gradient-to-b from-blue-500 to-transparent dark:bg-neutral-900">
                  <div class="absolute inset-0 bg-gradient-to-t from-gray-300 via-transparent to-transparent"></div>
                  <img src="https://la27ferreteria.com.ar/storage/files/shares/Heros/banner_la27_lg.png" alt="Imagen con degradado" class="w-full">
              </div>
          	</div>
			--}}

        </div>
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

  <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 space-x-2"></div>


</div>
<!-- End Slider -->