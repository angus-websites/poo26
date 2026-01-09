<x-layouts.minimal>
    <x-page-container>
        <div class="max-w-3xl mx-auto">
            <flux:card class="space-y-6">
                <article class="prose dark:prose-invert">
                    <x-markdown>
                        {!! $message->content !!}
                    </x-markdown>
                </article>
            </flux:card>
        </div>
    </x-page-container>
</x-layouts.minimal>
