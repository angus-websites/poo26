<header>
    <div class="">
        <div
            class="mx-auto flex max-w-7xl items-center justify-center p-6 md:space-x-10 px-8">
            <div class="flex justify-center lg:w-0 lg:flex-1">
                <a href="{{ route('home') }}" class="flex items-center justify-center" wire:navigate>
                    <x-app-logo/>
                </a>
            </div>
        </div>
    </div>

    <x-container>
        <flux:navbar class="mx-auto max-w-3xl justify-center">
            <flux:navbar.item href="#" icon="home" current>Home</flux:navbar.item>
            <flux:navbar.item href="#" icon="envelope">Message</flux:navbar.item>
            <flux:navbar.item href="#" icon="code-bracket">Snippets</flux:navbar.item>
        </flux:navbar>
    </x-container>
</header>

