<?php

use App\Exceptions\CodeGeneratorException;
use App\Services\LinkService;
use Livewire\Volt\Component;
use App\Services\Util\UrlNormalizerService;

new class extends Component {

    public string $url = '';

    protected array $rules = [
        'url' => ['required', 'url', 'max:2048'],
    ];

    public function submit(LinkService $linkService): void
    {
        // Normalize the URL
        $this->url = UrlNormalizerService::normalize($this->url);

        // Validate the input
        $this->validate();

        try {
            // Create the shortened link
            $link = $linkService->create(
                originalUrl: $this->url
            );
        } catch (CodeGeneratorException) {
            session()->flash('error', 'Failed to shorten the URL. Please try again.');
            return;
        }

        // Emit the shortened URL event
        $this->dispatch('link:shortened', [
            'short_url' => $link->slug,
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

        <flux:field>
            <flux:label>Enter URL to shorten</flux:label>
            <flux:input wire:model.defer="url"
                        required
                        icon="link"
                        inputmode="url"
                        type="text"
                        placeholder="https://example.com"/>
            <flux:error name="url"/>
        </flux:field>

        <div class="space-y-2">
            <flux:button type="submit" variant="primary" class="w-full">Shorten</flux:button>
        </div>
    </form>
</div>


