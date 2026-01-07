<?php

use App\Services\LinkService;
use App\Services\SlugService;
use App\Contracts\LinkRepositoryInterface;
use App\Data\LinkData;
use App\Models\Link;

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
