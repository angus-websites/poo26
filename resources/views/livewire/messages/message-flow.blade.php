<?php

use Livewire\Volt\Component;

new class extends Component {

    /**
     * Flow state
     * form | result
     */
    public string $stage = 'form';

};
?>

<flux:card class="space-y-6">

    @if ($stage === 'form')
        <livewire:messages.message-form/>
    @endif

</flux:card>
