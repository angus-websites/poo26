<?php

use Livewire\Volt\Component;

new class extends Component {

    /**
     * Flow state
     * form | result
     */
    public string $stage = 'form';

    /**
     * The generated URL code
     */
    public ?string $urlCode = null;

    protected $listeners = [
        'link:shortened' => 'onLinkShortened',
        'link:reset' => 'resetFlow',
    ];

    public function onLinkShortened(array $payload): void
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
        <livewire:links.link-form/>
    @elseif($stage === 'result')
        <livewire:links.link-results :urlCode="$urlCode"/>
    @endif

</flux:card>
