<?php

use Livewire\Volt\Component;

new class extends Component {

    /**
     * The shortened URL to display
     */
    public string $urlCode;

    /**
     * Configurable UI text
     */
    public string $heading = 'Your new link!';
    public string $backButtonText = 'Shorten again';

    public function mount(
        string $urlCode,
        ?string $heading = null,
        ?string $backButtonText = null,
    ): void
    {

        // Format the URL
        $this->urlCode = url($urlCode);

        // Allow overrides, fall back to defaults
        if ($heading !== null) {
            $this->heading = $heading;
        }

        if ($backButtonText !== null) {
            $this->backButtonText = $backButtonText;
        }
    }
};
?>

<div class="space-y-6" x-data="{ url: $wire.entangle('urlCode') }" >

    <flux:heading size="lg">
        {{ $heading }}
    </flux:heading>

    <div class="space-y-2">
        <label id="short_url"
               class="text-center border-gray-200 dark:border-gray-200/10 border font-mono [&::selection]:bg-green-200 [&::selection]:text-green-900 text-zinc-500 dark:text-zinc-300 col-span-6 bg-white/10  text-sm rounded-lg block w-full px-2.5 py-4 truncate overflow-hidden">
            {{ $urlCode }}
        </label>
    </div>

    <div class="flex space-x-2 items-center justify-between flex-row">
        <flux:button
            variant="ghost"
            class="w-full"
            wire:click="$dispatch('link:reset')"
        >
            {{ $backButtonText }}
        </flux:button>

        <flux:button
            variant="primary"
            class="w-full"
            x-data="{ copied: false }"
            x-on:click="$clipboard(url);copied = true; setTimeout(() => copied = false, 2000);"
        >
            <flux:icon.clipboard
                variant="outline"
                x-show="!copied"
            />
            <flux:icon.clipboard-document-check
                variant="outline"
                x-cloak
                x-show="copied"
            />
            <span x-text="copied ? 'Copied' : 'Copy'"></span>
        </flux:button>
    </div>

</div>
