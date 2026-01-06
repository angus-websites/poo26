<x-layouts.public title="Shorten URL">
    <x-page-container>
        <div class="mt-16 max-w-xl mx-auto">
            <flux:card class="space-y-6">
                <div>
                    <flux:heading size="lg">Shorten a URL</flux:heading>
                </div>

                <div class="space-y-6">
                    <flux:input label="Enter URL to shorten" type="url" placeholder="https://example.com"/>
                </div>

                <div class="space-y-2">
                    <flux:button variant="primary" class="w-full">Shorten</flux:button>
                </div>
            </flux:card>
        </div>
    </x-page-container>
</x-layouts.public>
