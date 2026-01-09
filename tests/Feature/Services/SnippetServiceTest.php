<?php

use App\Contracts\SnippetRepositoryInterface;
use App\Exceptions\CodeGeneratorException;
use App\Models\Snippet;
use App\Services\LinkService;
use App\Services\SnippetService;

/**
 * SnippetService Test Suite
 *
 * This test suite verifies the functionality of the SnippetService,
 */
beforeEach(function () {
    $this->service = app(SnippetService::class);
});

it('creates a snippet and persists it to the database', function () {

    $content = 'print("Hello, World!");';
    $language = 'python';

    $snippet = $this->service->create($content, $language);

    // Assert returned model
    expect($snippet)
        ->toBeInstanceOf(Snippet::class)
        ->content->toBe($content)
        ->language->toBe($language)
        ->id->not->toBeNull();

    // Assert database state
    $this->assertDatabaseHas('snippets', [
        'id' => $snippet->id,
        'content' => $content,
        'language' => $language,
    ]);
});

it('creates a link for a snippet and persists it to the links table', function () {

    // Create snippet
    $snippet = $this->service->create('hello world');

    // Generate code
    $code = $this->service->createCodeForSnippet($snippet);

    // Assert code is non-empty
    expect($code)->toBeString()->not()->toBeEmpty();

    // Assert Link exists in database
    $this->assertDatabaseHas('links', [
        'code' => $code,
    ]);
});

it('propagates CodeGeneratorException when link creation fails', function () {
    $snippet = $this->service->create('bad snippet content');

    // Mock LinkService to throw
    $mockLinkService = Mockery::mock(LinkService::class);
    $mockLinkService->shouldReceive('create')
        ->once()
        ->andThrow(CodeGeneratorException::class);

    // Create SnippetService with mocked LinkService
    $service = new SnippetService(app(SnippetRepositoryInterface::class), $mockLinkService);

    $service->createCodeForSnippet($snippet);
})->throws(CodeGeneratorException::class);
