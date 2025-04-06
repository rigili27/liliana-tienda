{{-- <x-filament::card>
    <x-filament::button wire:click="refreshBusinesses" color="primary">
        Refrescar Tabla Negocios
    </x-filament::button>
    
</x-filament::card> --}}
<div class="col-span-full">
    <x-filament::section>
        <x-slot name="heading">
            Migrate refresh
        </x-slot>

        <x-filament::button wire:click="refreshBusinesses" color="primary">
            Business Refresh
        </x-filament::button>

        <x-filament::button wire:click="refreshUsers" color="primary">
            Users Refresh
        </x-filament::button>

        <x-filament::button wire:click="refreshOrders" color="primary">
            Orders Refresh
        </x-filament::button>

        <x-filament::button wire:click="refreshProducts" color="primary">
            Products Refresh
        </x-filament::button>

        <x-filament::button wire:click="refreshCompanySettings" color="primary">
            CompanySettings Refresh
        </x-filament::button>

        <x-filament::button wire:click="refreshHeros" color="primary">
            Heros Refresh
        </x-filament::button>

    </x-filament::section>


</div>
