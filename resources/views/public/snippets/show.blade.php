<x-layouts.minimal title="Poo">
    <x-page-container>
        <div class="max-w-3xl mx-auto">
            <flux:card class="space-y-6">
                <x-markdown theme="github-dark">
                    ```{!! $snippet->language !!}
                    {!! $snippet->content !!}
                    
                </x-markdown>
            </flux:card>
        </div>
    </x-page-container>
</x-layouts.minimal>
