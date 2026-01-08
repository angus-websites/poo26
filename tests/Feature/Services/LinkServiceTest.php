<?php

use App\Exceptions\InvalidLinkException;
use App\Models\Destination;
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

    // Create a link in the database
    $link = Destination::create([
        'original_url' => 'https://example.com',
        'slug' => 'testslug',
        'is_active' => true,
        'clicks' => 0,
        'expires_at' => Carbon::now()->addDay(), // not expired
    ]);

    // Call resolve
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

    $link = Destination::create([
        'original_url' => 'https://example.com',
        'slug' => 'expiredslug',
        'is_active' => true,
        'clicks' => 0,
        'expires_at' => Carbon::now()->subDay(), // expired
    ]);

    $this->service->resolve($link);
})->throws(InvalidLinkException::class);

it('throws InvalidLinkException if link is inactive', function () {
    Carbon::setTestNow(Carbon::parse('2026-01-07 12:00:00'));

    $link = Destination::create([
        'original_url' => 'https://example.com',
        'slug' => 'inactiveslug',
        'is_active' => false,
        'clicks' => 0,
        'expires_at' => Carbon::now()->addDay(),
    ]);

    $this->service->resolve($link);
})->throws(InvalidLinkException::class);

it('creates a link successfully', function () {
    $originalUrl = 'https://example.com/some-page';

    $link = $this->service->create($originalUrl);

    expect($link->original_url)->toBe($originalUrl)
        ->and($link->slug)->not->toBeEmpty();

    $linkInDb = Destination::where('slug', $link->slug)->first();
    expect($linkInDb)->not->toBeNull()
        ->and($linkInDb->original_url)->toBe($originalUrl);
});

it('returns existing link if the same URL is already active', function () {
    $originalUrl = 'https://example.com';

    // Create existing active link
    $existing = Destination::create([
        'original_url' => $originalUrl,
        'slug' => 'activeslug',
        'clicks' => 0,
        'is_active' => true,
        'expires_at' => null,
    ]);

    // Attempt to create same URL
    $link = $this->service->create($originalUrl);

    // Assert the same link is returned and 1 link exists in DB
    expect($link->id)->toBe($existing->id)
        ->and(Destination::count())->toBe(1);

});

it('creates a new link if the existing link is inactive', function () {
    $originalUrl = 'https://example.com';

    // Create inactive link
    Destination::create([
        'original_url' => $originalUrl,
        'slug' => 'inactive-slug',
        'clicks' => 0,
        'is_active' => false,
        'expires_at' => null,
    ]);

    // Attempt to create same URL
    $link = $this->service->create($originalUrl);

    // Assert a new link is created
    expect($link->slug)->not->toBe('inactive-slug')
        ->and($link->original_url)->toBe($originalUrl)
        ->and(Destination::count())->toBe(2);

});

it('creates a new link if the existing link is expired', function () {
    Carbon::setTestNow('2026-01-02 12:00:00');
    $originalUrl = 'https://example.com';

    // Create expired link
    Destination::create([
        'original_url' => $originalUrl,
        'slug' => 'expired-slug',
        'clicks' => 0,
        'is_active' => true,
        'expires_at' => Carbon::now()->subDay(),
        'url_hash' => hash('sha256', $originalUrl),
    ]);

    // Attempt to create same URL
    $link = $this->service->create($originalUrl);

    // Assert new link created
    expect($link->slug)->not->toBe('expired-slug')
        ->and($link->original_url)->toBe($originalUrl)
        ->and(Destination::count())->toBe(2);

    // DB should have 2 links
});
