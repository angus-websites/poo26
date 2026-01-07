<?php

namespace App\Services;

use App\Contracts\MessageRepositoryInterface;
use App\Models\Message;

class MessageService
{
    public function __construct(
        protected MessageRepositoryInterface $messageRepository,
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



}
