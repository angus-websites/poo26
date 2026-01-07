<?php

namespace App\Services;

use App\Contracts\MessageRepositoryInterface;
use App\Exceptions\SlugException;
use App\Models\Message;

class MessageService
{
    public function __construct(
        protected MessageRepositoryInterface $messageRepository,
        protected LinkService $linkService
    )
    {}

    /**
     * Create a new message
     *
     * @param string $content The content of the message
     */
    public function create(string $content): Message
    {
        return $this->messageRepository->create(
            [
                'content' => $content,
            ]
        );
    }

    /**
     * Create a URL for accessing the message
     *
     * @param Message $message The message to create a URL for
     * @return string The slug of the created link
     * @throws SlugException
     */
    public function createSlugForMessage(Message $message): string
    {
        $link = $this->linkService->create(
            route('messages.show', ['message' => $message->id], false)
        );

        return $link->slug;
    }



}
