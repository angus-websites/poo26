<?php

use App\Contracts\MessageRepositoryInterface;
use App\Exceptions\SlugException;
use App\Models\Message;
use App\Services\LinkService;
use App\Services\MessageService;

/**
 * MessageService Test Suite
 *
 * This test suite verifies the functionality of the MessageService
 */
beforeEach(function () {
    $this->service = app(MessageService::class);
});

it('creates a message and persists it to the database', function () {

    $content = 'Hello **Markdown** world';

    $message = $this->service->create($content);

    // Assert returned model
    expect($message)
        ->toBeInstanceOf(Message::class)
        ->content->toBe($content)
        ->id->not->toBeNull();

    // Assert database state
    $this->assertDatabaseHas('messages', [
        'id' => $message->id,
        'content' => $content,
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
    $message = $this->service->create('Failing message');

    // Mock LinkService to throw
    $mockLinkService = Mockery::mock(LinkService::class);
    $mockLinkService->shouldReceive('create')
        ->once()
        ->andThrow(SlugException::class);

    // Create MessageService with mocked LinkService
    $service = new MessageService(app(MessageRepositoryInterface::class), $mockLinkService);

    $service->createSlugForMessage($message);
})->throws(SlugException::class);
