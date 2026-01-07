<x-layouts.minimal title="Poo">
    <x-page-container>
        <div class="max-w-3xl mx-auto">
            <flux:card class="space-y-6">
                <article class="prose dark:prose-invert">{!! $htmlContent !!}</article>
            </flux:card>
        </div>
    </x-page-container>
</x-layouts.minimal>
