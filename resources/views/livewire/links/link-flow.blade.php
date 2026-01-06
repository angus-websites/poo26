<?php

use Livewire\Volt\Component;

new class extends Component {

    /**
     * Flow state
     * form | result
     */
    public string $stage = 'form';

    /**
     * The generated short URL
     */
    public ?string $shortUrl = null;

    protected $listeners = [
        'link:shortened' => 'onLinkShortened',
        'link:reset' => 'resetFlow',
    ];

    public function onLinkShortened(array $payload): void
    {
        $this->shortUrl = $payload['short_url'] ?? null;
        $this->stage = 'result';
    }

    public function resetFlow(): void
    {
        $this->reset(['shortUrl']);
        $this->stage = 'form';
    }
};
?>

<flux:card class="space-y-6">

    @if ($stage === 'form')
        <livewire:links.link-form/>
    @endif

    @if ($stage === 'result')
        <livewire:links.link-results :shortUrl="$shortUrl"/>
    @endif

</flux:card>
