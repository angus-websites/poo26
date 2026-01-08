<?php

use App\Contracts\MessageRepositoryInterface;
use App\Contracts\SnippetRepositoryInterface;
use App\Exceptions\SlugException;
use App\Models\Message;
use App\Models\Snippet;
use App\Services\LinkService;
use App\Services\MessageService;
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

it('creates a link for a message and persists it to the links table', function () {

    // Create message
    $message = $this->service->create('Test message for slug');

    // Generate slug
    $slug = $this->service->createSlugForMessage($message);

    // Assert slug is non-empty
    expect($slug)->toBeString()->not()->toBeEmpty();

    // Assert Link exists in database
    $this->assertDatabaseHas('links', [
        'slug' => $slug,
        'original_url' => route('messages.show', ['message' => $message->id], false),
    ]);
});

it('propagates SlugException when link creation fails', function () {
    $snippet = $this->service->create('bad snippet content');

    // Mock LinkService to throw
    $mockLinkService = Mockery::mock(LinkService::class);
    $mockLinkService->shouldReceive('create')
        ->once()
        ->andThrow(SlugException::class);

    // Create SnippetService with mocked LinkService
    $service = new SnippetService(app(SnippetRepositoryInterface::class), $mockLinkService);

    $service->createSlugForSnippet($snippet);
})->throws(SlugException::class);
