<?php

use App\Services\MessageService;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {

    public string $snippet = '';
    public string $language = '';


    protected function rules(): array
    {
        return [
            'snippet' => ['required', 'string', 'max:5000'],
            'language' => ['nullable', Rule::in(array_keys(config('snippets.languages')))],
        ];
    }


    public function submit(MessageService $messageService): void
    {
        $this->validate();

//        // Emit the shortened Message event
//        $this->dispatch('snippet:shortened', [
//            'short_url' => $shortUrl,
//        ]);

        // Reset the form
        $this->reset([
            'snippet',
            'language',
        ]);
    }
}
?>
<div>
    @if (session()->has('error'))
        <flux:callout class="mb-4" variant="danger" icon="x-circle" :heading="session('error')"/>
    @endif

    <form class="space-y-6" wire:submit="submit">
        <div>
            <flux:heading size="lg">Create a snippet</flux:heading>
        </div>

        <flux:field>
            <flux:label>Select a programming language</flux:label>
            <flux:select wire:model="language" variant="listbox" searchable placeholder="Select language...">
                @foreach(config('snippets.languages') as $key => $info)
                    <flux:select.option value="{{ $key }}">
                        <div class="flex items-center gap-2">
                            <i class="{{$info['icon']}}"></i>
                            <span>{{ $info['label'] }}</span>
                        </div>
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:error name="language"/>
        </flux:field>


        <flux:field>
            <flux:label>Enter your code</flux:label>
            <flux:textarea
                wire:model.defer="snippet"
                required
                placeholder="print('Hello, World!')"
            />
            <flux:error name="snippet"/>
            <flux:description>
                Content is limited to 5000 characters.
            </flux:description>
        </flux:field>

        <div class="space-y-2">
            <flux:button type="submit" variant="primary" class="w-full">Get Link</flux:button>
        </div>
    </form>
</div>


