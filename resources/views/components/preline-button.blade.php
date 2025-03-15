<button {{ $attributes->merge(['class' => 'inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent  disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
