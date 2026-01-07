<?php

use App\Models\Link;
use App\Services\LinkService;
use App\Services\SlugService;
use App\Contracts\LinkRepositoryInterface;
use App\Exceptions\InvalidLinkException;
use Illuminate\Support\Carbon;

/**
 * LinkService Test Suite
 *
 * This test suite verifies the functionality of the LinkService,
 * including link resolution, click tracking, and link creation.
 */

beforeEach(function () {
    // Create a real repository instance or mock if needed
    $this->repo = app(LinkRepositoryInterface::class);
    $this->slugService = app(SlugService::class);

    $this->service = new LinkService(
        $this->repo,
        $this->slugService
    );
});

it('resolves an active link and increments clicks', function () {
    // Freeze time
    $now = Carbon::parse('2026-01-02 12:00:00');
    Carbon::setTestNow($now);

    // Create a link in the database
    $link = Link::create([
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

    $link = Link::create([
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

    $link = Link::create([
        'original_url' => 'https://example.com',
        'slug' => 'inactiveslug',
        'is_active' => false,
        'clicks' => 0,
        'expires_at' => Carbon::now()->addDay(),
    ]);

    $this->service->resolve($link);
})->throws(InvalidLinkException::class);

it ('creates a link successfully', function () {
    $originalUrl = 'https://example.com/some-page';

    $link = $this->service->create($originalUrl);

    expect($link->original_url)->toBe($originalUrl)
        ->and($link->slug)->not->toBeEmpty();

    $linkInDb = Link::where('slug', $link->slug)->first();
    expect($linkInDb)->not->toBeNull()
        ->and($linkInDb->original_url)->toBe($originalUrl);
});
