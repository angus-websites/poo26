<?php

use Livewire\Livewire;

it('has initial state with form stage', function () {
    Livewire::test('links.link-flow')
        ->assertSet('stage', 'form')
        ->assertSet('shortUrl', null)
        ->assertSeeLivewire('links.link-form')
        ->assertDontSeeLivewire('links.link-results');
});

it('switches to result stage when link:shortened event is emitted', function () {
    Livewire::test('links.link-flow')
        ->dispatch('link:shortened', ['short_url' => 'https://sho.rt/abc123'])
        ->assertSet('stage', 'result')
        ->assertSet('shortUrl', 'https://sho.rt/abc123')
        ->assertSeeLivewire('links.link-results')
        ->assertDontSeeLivewire('links.link-form');
});

it('resets flow when link:reset event is emitted', function () {
    Livewire::test('links.link-flow')
        // simulate going to result first
        ->dispatch('link:shortened', ['short_url' => 'https://sho.rt/abc123'])
        ->assertSet('stage', 'result')
        ->assertSet('shortUrl', 'https://sho.rt/abc123')
        // now reset
        ->dispatch('link:reset')
        ->assertSet('stage', 'form')
        ->assertSet('shortUrl', null)
        ->assertSeeLivewire('links.link-form')
        ->assertDontSeeLivewire('links.link-results');
});
