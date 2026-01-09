<?php

it('can create new link', function () {

    $page = visit('/');

    $page->fill('url', 'https://example.com')
        ->press('Shorten')
        ->assertSee('Your new link!');
});

it('can create new link without url scheme', function () {

    $page = visit('/');

    $page->fill('url', 'google.com')
        ->press('Shorten')
        ->assertSee('Your new link!');

});

it('doesnt allow invalid urls', function () {

    $page = visit('/');

    $page->fill('url', 'invalid')
        ->press('Shorten')
        ->wait(0.1)
        ->assertDontSee('Your new link!');
});

it('following generated link redirects correctly', function () {

    $page = visit('/');

    $page->fill('url', 'https://example.com')
        ->press('Shorten')
        ->assertSee('Your new link!');

    // Extract the generated link from the page
    $shortenedUrl = trim($page->text('#short_url'));

    // Assert that visiting the shortened URL redirects to the original URL
    $this->get($shortenedUrl)
        ->assertRedirect($uri = 'https://example.com');

});


it('generating link without URL scheme redirects to https', function () {

    $page = visit('/');

    $page->fill('url', 'example.com')
        ->press('Shorten')
        ->assertSee('Your new link!');

    // Extract the generated link from the page
    $shortenedUrl = trim($page->text('#short_url'));

    // Assert that visiting the shortened URL redirects to the original URL
    $this->get($shortenedUrl)
        ->assertRedirect($uri = 'https://example.com');

});
