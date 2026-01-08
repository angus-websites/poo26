<x-layouts.minimal title="Poo">
    <x-page-container>
        <div class="max-w-3xl mx-auto">

            <flux:card class="dark:bg-[#282A36]">
                <flux:heading class="flex items-center gap-2">Language: {{ $languageName }}
                    <flux:tooltip content="Copy to Clipboard" class="ml-auto">
                        <flux:button icon="clipboard-document"/>
                    </flux:tooltip>
                </flux:heading>
                <div class="mt-2">
                    {!! $htmlContent !!}
                </div>
            </flux:card>
        </div>
    </x-page-container>
</x-layouts.minimal>
