<?php

it('can create new message', function () {

    $page = visit('/messages/create');

    $page->fill('message', 'example content')
         ->press('Get Link')
         ->assertSee('Your message is ready!');
});

it('doesnt allow empty messages', function () {

    $page = visit('/messages/create');

    $page->press('Get Link')
        ->assertDontSee('Your message is ready!');
});
