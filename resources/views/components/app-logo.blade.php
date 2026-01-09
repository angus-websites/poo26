@props([
    'mode' => 'auto', // auto | light | dark
])
<div class="text-center">
    @if ($mode === 'light')
        <img {{ $attributes->class('h-10 mx-auto') }}
             src="{{ asset('assets/images/logo/logo.png') }}" alt="Poo Logo">
    @elseif ($mode === 'dark')
        <img {{ $attributes->class('h-10 mx-auto') }}
             src="{{ asset('assets/images/logo/logo-light.png') }}" alt="Poo Logo">
    @else
        {{-- auto (Tailwind dark mode) --}}
        <img {{ $attributes->class('dark:hidden h-10 mx-auto') }}
             src="{{ asset('assets/images/logo/logo.png') }}" alt="Poo Logo">

        <img {{ $attributes->class('hidden dark:block h-10 mx-auto') }}
             src="{{ asset('assets/images/logo/logo-light.png') }}" alt="Poo Logo">
    @endif
    <p class="mt-2 text-black/60 dark:text-white/60">Point of Origin URL shortener</p>
</div>
