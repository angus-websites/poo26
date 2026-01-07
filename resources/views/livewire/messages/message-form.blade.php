<?php

use App\Exceptions\SlugException;
use App\Services\LinkService;
use App\Services\MessageService;
use Livewire\Volt\Component;

new class extends Component {

    public string $message = '';

    protected array $rules = [
        'message' => ['required', 'string', 'max:3000'],
    ];

    public function submit(MessageService $messageService): void
    {
        $this->validate();

        try {
            $message = $messageService->create($this->message);
        } catch (Exception) {
            session()->flash('error', 'Failed to create message. Please try again.');
            return;
        }

        // Reset the form
        $this->reset('message');
    }
}
?>
<div>
    @if (session()->has('error'))
        <flux:callout class="mb-4" variant="danger" icon="x-circle" :heading="session('error')"/>
    @endif
    <form class="space-y-6" wire:submit="submit">
        <div>
            <flux:heading size="lg">Create a message</flux:heading>
        </div>

        <div class="space-y-6">
            <flux:textarea
                wire:model.defer="message"
                label="Enter your message"
                placeholder="Your message here..."
            />
        </div>

        <div class="space-y-2">
            <flux:button type="submit" variant="primary" class="w-full">Get Link</flux:button>
        </div>
    </form>
</div>


