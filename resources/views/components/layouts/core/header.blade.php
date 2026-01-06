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
            <flux:navbar.item wire:navigate :href="route('home')" :current="request()->routeIs('home')" icon="home" >Home</flux:navbar.item>
            <flux:navbar.item wire:navigate :href="route('messages.create')" :current="request()->routeIs('messages.create')" icon="envelope">Message</flux:navbar.item>
            <flux:navbar.item wire:navigate :href="route('snippets.create')" :current="request()->routeIs('snippets.create')" icon="code-bracket">Snippets</flux:navbar.item>
        </flux:navbar>
    </x-container>
</header>

