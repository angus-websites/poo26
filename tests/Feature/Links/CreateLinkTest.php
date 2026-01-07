<?php

it('can create new link', function () {

    $page = visit('/');

    $page->fill('url', 'https://example.com')
         ->press('Shorten')
         ->assertSee('Your new link!');
});

it('doesnt allow invalid urls', function () {

    $page = visit('/');

    $page->fill('url', 'invalid -url')
        ->press('Shorten')
        ->assertDontSee('Your new link!');
});
