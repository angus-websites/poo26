<x-layouts.public title="Create Message">
    <x-page-container>
        <div class="mt-16 max-w-xl mx-auto">
            <flux:card class="space-y-6">
                <div>
                    <flux:heading size="lg">Create a message</flux:heading>
                </div>

                <div class="space-y-6">
                    <flux:textarea
                        label="Enter your message"
                        placeholder="Your message here..."
                    />
                </div>

                <div class="space-y-2">
                    <flux:button variant="primary" class="w-full">Shorten</flux:button>
                </div>
            </flux:card>
        </div>
    </x-page-container>
</x-layouts.public>
