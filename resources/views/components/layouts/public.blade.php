<x-layouts.core.master>
    @section('title', $title ?? null)
    <div class="min-h-screen flex flex-col">
        <x-layouts.core.header/>
        <x-layouts.core.navigation/>
        <div class="flex-1">
            {{ $slot }}
        </div>
        <x-layouts.core.footer/>
    </div>
</x-layouts.core.master>
