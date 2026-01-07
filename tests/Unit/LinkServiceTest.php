<?php

use App\Exceptions\InvalidLinkException;
use App\Services\LinkService;
use App\Services\SlugService;
use App\Contracts\LinkRepositoryInterface;
use App\Data\LinkData;
use App\Models\Link;
use Carbon\Carbon;

beforeEach(function () {
    $this->repo = Mockery::mock(LinkRepositoryInterface::class);
    $this->slugService = Mockery::mock(SlugService::class);

    $this->service = new LinkService($this->repo, $this->slugService);
});

it('creates a link and returns a LinkData DTO', function () {
    $originalUrl = 'https://example.com';

    // Mock slug generation
    $slug = 'abc123';
    $this->slugService
        ->shouldReceive('generate')
        ->once()
        ->andReturn($slug);

    // Create what the repository should return
    $linkModel = new Link([
        'slug' => $slug,
        'original_url' => $originalUrl,
        'clicks' => 0,
        'is_active' => true,
        'expires_at' => null,
        'last_accessed' => null,
    ]);

    // Mock repository create method
    $this->repo
        ->shouldReceive('create')
        ->once()
        ->withArgs(function (LinkData $data) use ($slug, $originalUrl) {
            expect($data->slug)->toBe($slug);
            expect($data->originalUrl)->toBe($originalUrl);
            return true;
        })
        ->andReturn($linkModel);

    $dto = $this->service->create($originalUrl);

    expect($dto)->toBeInstanceOf(LinkData::class)
        ->and($dto->slug)->toBe($slug)
        ->and($dto->originalUrl)->toBe($originalUrl);
});

it('resolves an active link and tracks access', function () {

    // Set current time for consistent testing
    $now = Carbon::parse('2026-01-02 12:00:00');
    Carbon::setTestNow($now);

    // Create a link model
    $link = new Link([
        'original_url' => 'https://example.com',
        'is_active' => true,
        'expires_at' => null,
        'clicks' => 0,
        'last_accessed' => null,
    ]);

    // Mock repository update method
    $this->repo
        ->shouldReceive('update')
        ->once()
        ->withArgs(function ($model, $data) use ($now) {
            expect($data['clicks'])->toBe(1)
                ->and($data['last_accessed'])->toEqual($now);
            return true;
        });

    $url = $this->service->resolve($link);

    expect($url)->toBe('https://example.com');
});

it('throws error if link is inactive', function () {

    // Create a link where is_active is false
    $link = new Link([
        'is_active' => false,
        'expires_at' => null,
    ]);

    // Ensure update is not called
    $this->repo->shouldNotReceive('update');

    // Attempt to resolve the link
    $this->service->resolve($link);

})->throws(InvalidLinkException::class);

it('throws error if link is expired', function () {

    $now = Carbon::parse('2026-01-02 12:00:00');
    Carbon::setTestNow($now);
    $past = Carbon::now()->subDay();

    $link = Mockery::mock(Link::class)->makePartial();
    $link->is_active = true;
    $link->expires_at = $past;

    $this->repo->shouldNotReceive('update');

    $this->service->resolve($link);

})->throws(InvalidLinkException::class);
