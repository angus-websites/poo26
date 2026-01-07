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
        'message:shortened' => 'onMessageShortened',
        'link:reset' => 'resetFlow',
    ];

    public function onMessageShortened(array $payload): void
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
        <livewire:messages.message-form/>
    @elseif($stage === 'result')
        <livewire:links.link-results
            :shortUrl="$shortUrl"
            heading="Your message is ready!"
            backButtonText="Create another message"
        />
    @endif

</flux:card>
