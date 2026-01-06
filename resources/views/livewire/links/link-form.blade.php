<?php

use Livewire\Volt\Component;

new class extends Component {

    public string $url = '';

    protected array $rules = [
        'url' => ['required', 'url', 'max:2048'],
    ];

    public function submit(): void
    {
        $this->validate();

        // Emit the shortened URL event
        $this->dispatch('url:shortened', ['url' => $this->url]);

        // Reset the form
        $this->reset('url');
    }
}
?>
<flux:card class="space-y-6">
    <form class="space-y-6" wire:submit="submit">
        <div>
            <flux:heading size="lg">Shorten a URL</flux:heading>
        </div>

        <div class="space-y-6">
            <flux:input wire:model.defer="url" label="Enter URL to shorten" type="url" placeholder="https://example.com"/>
        </div>

        <div class="space-y-2">
            <flux:button type="submit" variant="primary" class="w-full">Shorten</flux:button>
        </div>
    </form>
</flux:card>

