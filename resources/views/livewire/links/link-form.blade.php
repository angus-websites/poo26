<?php

use App\Exceptions\SlugException;
use App\Services\LinkService;
use Livewire\Volt\Component;

new class extends Component {

    public string $url = '';

    protected array $rules = [
        'url' => ['required', 'url', 'max:2048'],
    ];

    public function submit(LinkService $linkService): void
    {
        $this->validate();

        try {
            // Create the shortened link
            $linkData = $linkService->create(
                originalUrl: $this->url
            );
        } catch (SlugException) {
            session()->flash('error', 'Failed to shorten the URL. Please try again.');
            return;
        }

        // Emit the shortened URL event
        $this->dispatch('link:shortened', [
            'short_url' => $linkData->slug,
        ]);

        // Reset the form
        $this->reset('url');
    }
}
?>
<div>
    @if (session()->has('error'))
        <flux:callout class="mb-4" variant="danger" icon="x-circle" :heading="session('error')"/>
    @endif
    <form class="space-y-6" wire:submit="submit">
        <div>
            <flux:heading size="lg">Shorten a URL</flux:heading>
        </div>

        <div class="space-y-6">
            <flux:input wire:model.defer="url" required icon="link" label="Enter URL to shorten" type="url"
                        placeholder="https://example.com"/>
        </div>

        <div class="space-y-2">
            <flux:button type="submit" variant="primary" class="w-full">Shorten</flux:button>
        </div>
    </form>
</div>


