<div>
    {{-- horarios --}}
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-center p-6 bg-white rounded-lg shadow-md dark:bg-neutral-900" aria-haspopup="dialog" aria-expanded="false" aria-controls="cart-modal" data-hs-overlay="#cart-modal">
                <div class="w-12 h-12 flex-shrink-0 text-blue-600 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                </div>

                @if ($todaySchedule)
                    <div class="ml-4">
                        <p class="text-gray-800 dark:text-white font-semibold">Horario de hoy 🙌</p>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">Mañana: {{ $todaySchedule['open'] ?? 'Cerrado' }} - {{ $todaySchedule['close'] ?? 'Cerrado' }}</p>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">Tarde: {{ $todaySchedule['open_afternoon'] ?? 'Cerrado' }} - {{ $todaySchedule['close_afternoon'] ?? 'Cerrado' }}</p>
                    </div>
                @else
                    <div class="ml-4">
                        <p class="text-gray-800 dark:text-white font-semibold">Hoy esta cerrado ⚠️</p>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">Consulta los días y horarios haciendo click acá</p>
                    </div>
                @endif

            </div>
            <div class="flex items-center p-6 bg-white rounded-lg shadow-md dark:bg-neutral-900">
                <div class="w-12 h-12 flex-shrink-0 text-blue-600 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-800 dark:text-white font-semibold">Visitanos en</p>
                    @foreach ($addresses as $address)
                        <p class="text-sm text-gray-600 dark:text-neutral-400">📍 {{ $address['address'] }}</p>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center p-6 bg-white rounded-lg shadow-md dark:bg-neutral-900">
                <div class="w-12 h-12 flex-shrink-0 text-blue-600 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>

                </div>
                <div class="ml-4">
                    <p class="text-gray-800 dark:text-white font-semibold">Teléfono</p>
                    @foreach ($phones as $phone)
                        <p class="text-sm text-gray-600 dark:text-neutral-400">📱 {{ $phone['number'] }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
