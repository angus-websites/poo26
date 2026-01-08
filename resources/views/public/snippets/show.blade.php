<x-layouts.minimal title="Poo">
    <x-page-container>
        <div class="max-w-3xl mx-auto">

            <flux:card class="dark:bg-[#282A36]">
                <flux:heading class="flex items-center gap-2">Language: {{ $languageName }}
                    <flux:tooltip content="Copy to Clipboard" class="ml-auto">
                        <flux:button
                            square
                            content="{{ __('Copy me to clipboard') }}"
                            x-on:click="navigator.clipboard?.writeText($el.closest('[???]').value); $el.setAttribute('data-copied', ''); setTimeout(() => $el.removeAttribute('data-copied'), 2000)">
                            <flux:icon.clipboard variant="outline" class="[[data-copied]_&]:hidden"/>
                            <flux:icon.clipboard-document-check variant="outline"
                                                                class="hidden [[data-copied]_&]:block"/>
                        </flux:button>
                    </flux:tooltip>


                </flux:heading>


                <flux:separator class="my-5"/>
                <div id="snippet-content">
                    {!! $htmlContent !!}
                </div>
            </flux:card>
        </div>
    </x-page-container>
</x-layouts.minimal>
