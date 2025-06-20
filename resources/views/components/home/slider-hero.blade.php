<div>
    <div class="hidden md:block">
        <x-home.slider-hero-desktop :families="$families" :heros="$heros" :listattributes="$listattributes" />
    </div>
    <div class="block md:hidden">
        <x-home.slider-hero-movil :families="$families" :heros="$heros" :listattributes="$listattributes" />
    </div>
</div>