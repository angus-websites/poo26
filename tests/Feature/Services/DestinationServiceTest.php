<?php

use App\Models\Destination;
use App\Services\DestinationService;
use App\Services\LinkService;

/**
 * DestinationService Test Suite
 *
 * This test suite verifies the functionality of the DestinationService,
 */
beforeEach(function () {
    $this->service = app(DestinationService::class);
});

it('creates a destination successfully', function () {

    $originalUrl = 'https://example.com';

    $destination = $this->service->create($originalUrl);

    expect($destination)->toBeInstanceOf(Destination::class)
        ->and($destination->url)->toBe($originalUrl)
        ->and($destination->url_hash)->toBe(hash('sha256', $originalUrl));

    // Check the DB
    $this->assertDatabaseHas('destinations', [
        'id' => $destination->id,
        'url' => $originalUrl,
        'url_hash' => hash('sha256', $originalUrl),
    ]);

});

it('when two links for the same destination are created, only one destination record is created', function () {

    $originalUrl = 'https://example.com';

    $linkService = app(LinkService::class);
    $link1 = $linkService->create($originalUrl);
    $link2 = $linkService->create($originalUrl);

    expect($link1->destination_id)->toBe($link2->destination_id);

    // Assert there are two links but only one destination in the database
    $this->assertDatabaseCount('links', 2);
    $this->assertDatabaseCount('destinations', 1);

});
