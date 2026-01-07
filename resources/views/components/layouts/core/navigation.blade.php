<x-container>
    <flux:navbar class="mx-auto max-w-3xl justify-center">
        <flux:navbar.item wire:navigate :href="route('home')" :current="request()->routeIs('home')" icon="home">Home
        </flux:navbar.item>
        <flux:navbar.item wire:navigate :href="route('messages.create')"
                          :current="request()->routeIs('messages.create')" icon="envelope">Message
        </flux:navbar.item>
        <flux:navbar.item wire:navigate :href="route('snippets.create')"
                          :current="request()->routeIs('snippets.create')" icon="code-bracket">Snippets
        </flux:navbar.item>
    </flux:navbar>
</x-container>
