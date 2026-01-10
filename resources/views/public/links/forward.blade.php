<x-layouts.minimal title="Poo | Your Poo Link is Here!">
    @section('og-image', url('assets/images/core/ogimagelink.jpg'))
    @section('description', 'You have been sent a Poo link! Click to proceed to the destination.')

    <x-page-container>
        <div class="max-w-3xl mx-auto">
            <flux:card class="space-y-6 text-center" x-data x-init="window.location.href = '{{$targetUrl}}'">
                <p>If you are not redirected automatically, please below...</p>
                <flux:button :href="$targetUrl" variant="primary">Go!</flux:button>
            </flux:card>
        </div>
    </x-page-container>
</x-layouts.minimal>
