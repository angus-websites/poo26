<?php

use Livewire\Volt\Component;

new class extends Component {

    /**
     * Flow state
     * form | result
     */
    public string $stage = 'form';

    /**
     * The generated url code
     */
    public ?string $urlCode = null;

    protected $listeners = [
        'message:shortened' => 'onMessageShortened',
        'link:reset' => 'resetFlow',
    ];

    public function onMessageShortened(array $payload): void
    {
        $this->urlCode = $payload['url_code'] ?? null;
        $this->stage = 'result';
    }

    public function resetFlow(): void
    {
        $this->reset(['urlCode']);
        $this->stage = 'form';
    }
};
?>

<flux:card class="space-y-6">

    @if ($stage === 'form')
        <livewire:messages.message-form/>
    @elseif($stage === 'result')
        <livewire:links.link-results
            :urlCode="$urlCode"
            heading="Your message is ready!"
            backButtonText="Create another message"
        />
    @endif

</flux:card>
