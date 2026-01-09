<x-layouts.minimal>
    <x-page-container>
        <div class="max-w-3xl mx-auto" x-data="{ content: @js($rawContent) }">
            <flux:card class="dark:bg-[#282A36]">
                <flux:heading class="flex items-center gap-2">
                    Language: {{ $languageName }}

                    <flux:tooltip class="ml-auto" content="Copy to clipboard">
                        <flux:button
                            square
                            variant="primary"
                            x-data="{ copied: false }"
                            x-on:click="$clipboard(content);copied = true; setTimeout(() => copied = false, 2000);"
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
