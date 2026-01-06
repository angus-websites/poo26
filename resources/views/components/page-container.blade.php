<x-container>
    <div {{ $attributes->merge(['class' => 'pt-16 pb-8']) }}>
        {{ $slot }}
    </div>
</x-container>
