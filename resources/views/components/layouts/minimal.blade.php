<x-layouts.core.master :title="$title ?? null">
    <div class="min-h-screen flex flex-col">
        <x-layouts.core.header/>
        <div class="flex-1">
            {{ $slot }}
        </div>
        <x-layouts.core.footer/>
    </div>
</x-layouts.core.master>
