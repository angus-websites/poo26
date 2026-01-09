<?php

use App\Contracts\CodeRepositoryInterface;
use App\Exceptions\CodeGeneratorException;
use App\Services\Util\CodeGeneratorService;
use Illuminate\Support\Str;
use Mockery\Mock;

beforeEach(function () {
    $this->repo = Mockery::mock(CodeRepositoryInterface::class);
    $this->service = new CodeGeneratorService($this->repo);
});

it('generates a code of correct length', function () {
    $this->repo
        ->shouldReceive('findByCode')
        ->andReturnNull(); // always "unique"

    $code = $this->service->generate(10);

    expect(Str::length($code))->toBe(10)
        ->and($code)->toMatch('/^[a-zA-Z0-9]+$/');
});

it('generates a unique code after collisions', function () {
    $existingCodes = ['abc123', 'def456'];

    // Simulate collisions for the first two codes
    $this->repo
        ->shouldReceive('findByCode')
        ->andReturnUsing(function ($code) use ($existingCodes) {
            return in_array($code, $existingCodes)
                ? new Mock
                : null;
        });

    // Generate a code
    $code = $this->service->generate();

    expect($code)->not()->toBeIn($existingCodes);
});

it('throws exception if unable to generate code', function () {
    $this->repo
        ->shouldReceive('findByCode')
        ->andReturn(new Mock); // always collides

    $this->service
        ->generate(2, 2, 2); // tiny max length + attempts

})->throws(CodeGeneratorException::class);
