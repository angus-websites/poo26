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

it('doesnt allow cross site scripting', function () {

    $page = visit('/messages/create');

    $page->fill('message', '<script>console.log("Hello world")</script>')
        ->press('Get Link')
        ->assertSee('Your message is ready!');

    // Extract the generated link from the page
    $shortenedUrl = trim($page->text('#short_url'));

    // Assert that visiting the shortened URL does not execute script
    $newPage = visit($shortenedUrl);

    $newPage->assertNoConsoleLogs();
});
