<?php

use App\Exceptions\InvalidLinkException;
use App\Models\Destination;
use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Support\Carbon;

/**
 * LinkService Test Suite
 *
 * This test suite verifies the functionality of the LinkService,
 * including link resolution, click tracking, and link creation.
 */
beforeEach(function () {
    $this->service = app(LinkService::class);
});

it('resolves an active link and increments clicks', function () {
    // Freeze time
    $now = Carbon::parse('2026-01-02 12:00:00');
    Carbon::setTestNow($now);

    /**
     * Create an active link
     * @var Link $link
     */
    $link = Link::factory()
        ->forUrl('https://example.com')
        ->create([
            'is_active' => true,
            'code' => 'code123',
            'clicks' => 0,
            'last_accessed' => null,
        ]);


    // Call resolve with the link
    $url = $this->service->resolve($link);

    // Refresh the model from the database
    $link->refresh();

    // Assertions
    expect($url)->toBe('https://example.com')
        ->and($link->clicks)->toBe(1)
        ->and($link->last_accessed->eq($now))->toBeTrue();
});

it('throws InvalidLinkException if link is expired', function () {
    Carbon::setTestNow(Carbon::parse('2026-01-02 12:00:00'));

    /**
     * Create an expired link
     * @var Link $link
     */
    $link = Link::factory()
        ->forUrl('https://example.com')
        ->create([
            'is_active' => true,
            'code' => 'code123',
            'clicks' => 0,
            'last_accessed' => null,
            'expires_at' => Carbon::now()->subDay(), // Expired yesterday
        ]);

    $this->service->resolve($link);
})->throws(InvalidLinkException::class);

it('throws InvalidLinkException if link is inactive', function () {
    Carbon::setTestNow(Carbon::parse('2026-01-07 12:00:00'));

    /**
     * Create an inactive link
     * @var Link $link
     */
    $link = Link::factory()
        ->forUrl('https://example.com')
        ->create([
            'is_active' => false,
            'code' => 'code123',
            'clicks' => 0,
            'last_accessed' => null,
            'expires_at' => null,
        ]);

    $this->service->resolve($link);
})->throws(InvalidLinkException::class);

it('creates a link successfully', function () {
    $originalUrl = 'https://example.com/some-page';

    $link = $this->service->create($originalUrl);

    // Check the destination exists in DB
    $destination = Destination::where('url', $originalUrl)->first();
    expect($destination)->not->toBeNull();

    // Check the link in the DB
    $linkInDb = Link::where('code', $link->code)->first();
    expect($linkInDb)->not->toBeNull()
        ->and($linkInDb->destination_id)->toBe($destination->id)
        ->and($linkInDb->is_active)->toBeTrue()
        ->and($linkInDb->clicks)->toBe(0);

});


it('creates a new code for the same url', function () {

    $originalUrl = 'https://example.com';

    $link1 = $this->service->create($originalUrl);
    $link2 = $this->service->create($originalUrl);

    expect($link1->code)->not->toBe($link2->code);

});




