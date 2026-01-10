<x-layouts.public title="Poo | Share Code Snippets with Short URLs">
    @push('head')
        <link rel="stylesheet" type='text/css'
              href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css"/>

    @endpush
    <x-page-container>
    <div class="max-w-xl mx-auto">
        <livewire:snippets.snippet-flow/>
    </div>
    </x-page-container>
</x-layouts.public>
