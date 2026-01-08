<?php

use App\Services\SnippetService;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {

    public string $snippet = '';
    public string $language = 'plaintext';


    protected function rules(): array
    {
        $languages = array_merge(
            array_keys(config('snippets.languages.core', [])),
            array_keys(config('snippets.languages.syntax', [])),
        );

        return [
            'snippet' => ['required', 'string', 'max:5000'],
            'language' => ['nullable', Rule::in($languages)],
        ];
    }


    /**
     * The core languages like plaintext, etc.
     * without syntax highlighting.
     * @return array<string, array{label: string, icon?: string}>
     */
    public function getCoreLanguagesProperty(): array
    {
        $coreLanguages = config('snippets.languages')['core'] ?? [];

        uasort($coreLanguages, fn($a, $b) => strcasecmp($a['label'], $b['label']));

        return $coreLanguages;
    }

    /**
     * Get all available languages. with syntax highlighting.
     * @return array<string, array{label: string, icon?: string}>
     */
    public function getLanguagesProperty(): array
    {
        $languages = config('snippets.languages')['syntax'] ?? [];

        uasort($languages, fn($a, $b) => strcasecmp($a['label'], $b['label']));

        return $languages;
    }


    public function submit(SnippetService $snippetService): void
    {
        $this->validate();

        try {
            $message = $snippetService->create($this->snippet, $this->language);
            $shortUrl = $snippetService->createSlugForSnippet($message);
        } catch (Exception) {
            session()->flash('error', 'Failed to create snippet. Please try again.');
            return;
        }

        // Emit the shortened Message event
        $this->dispatch('snippet:shortened', [
            'short_url' => $shortUrl,
        ]);

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
                @foreach($this->coreLanguages as $key => $info)
                    <flux:select.option value="{{ $key }}">
                        <div class="flex items-center gap-2">
                            @isset($info['icon'])
                            <i class="{{$info['icon']}}"></i>
                            @endisset
                            <span>{{ $info['label'] }}</span>
                        </div>
                    </flux:select.option>
                @endforeach
                @foreach($this->languages as $key => $info)
                    <flux:select.option value="{{ $key }}">
                        <div class="flex items-center gap-2">
                            @isset($info['icon'])
                                <i class="{{$info['icon']}}"></i>
                            @endisset
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


