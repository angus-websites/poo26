<?php

use App\Contracts\LinkRepositoryInterface;
use App\Exceptions\SlugException;
use App\Models\Destination;
use App\Services\SlugService;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->repo = Mockery::mock(LinkRepositoryInterface::class);
    $this->slugService = new SlugService($this->repo);
});

it('generates a slug of correct length', function () {
    $this->repo
        ->shouldReceive('findBySlug')
        ->andReturnNull(); // always "unique"

    $slug = $this->slugService->generate(10);

    expect(Str::length($slug))->toBe(10)
        ->and($slug)->toMatch('/^[a-zA-Z0-9]+$/');
});

it('generates a unique slug after collisions', function () {
    $existingSlugs = ['abc123', 'def456'];

    $this->repo
        ->shouldReceive('findBySlug')
        ->andReturnUsing(function ($slug) use ($existingSlugs) {
            return in_array($slug, $existingSlugs)
                ? new Destination
                : null;
        });

    $slug = $this->slugService->generate();

    expect($slug)->not()->toBeIn($existingSlugs);
});

it('throws exception if unable to generate slug', function () {
    $this->repo
        ->shouldReceive('findBySlug')
        ->andReturn(new Destination); // always collides

    $this->slugService
        ->generate(2, 2, 2); // tiny max length + attempts

})->throws(SlugException::class);
