<div class="">

    <x-navbar :business="$business" :products="$list_products" />
    

    <div class="container mx-auto py-10">

        {{-- <div class="my-9">
            

            <x-preline-modal>
                <livewire:cart />
            </x-preline-modal>
        </div> --}}

        <div class="hidden">
            <x-text-input class="w-full" wire:model.defer="b" wire:keydown.enter="buscar"></x-text-input>
            {{-- <x-catalog.product.search-input :products="$list_products" /> --}}

            {{-- <x-text-input class="w-full" wire:model.live="b" ></x-text-input> --}}

        </div>

        <div class="my-5"></div>

        <div class="grid grid-cols-5 gap-8">
            <div>
                <x-catalog.sidebar.sidebar :families="$families" :categories="$categories" />
            </div>
            <div class="col-span-4">
                @foreach ($products as $product)
                    <x-catalog.product.horizontal :product="$product" />
                @endforeach

                <div class="mt-4">
                  {{ $products->links() }}
                </div>

            </div>            
        </div>
    </div>

    
</div>