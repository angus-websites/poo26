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
        'snippet:shortened' => 'onSnippetShortened',
        'link:reset' => 'resetFlow',
    ];

    public function onSnippetShortened(array $payload): void
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
        <livewire:snippets.snippet-form/>
    @elseif($stage === 'result')
        <livewire:links.link-results
            :shortUrl="$shortUrl"
            heading="Your snippet is ready!"
            backButtonText="Create another snippet"
        />
    @endif

</flux:card>
