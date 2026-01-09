<?php

namespace App\Services;

use App\Contracts\MessageRepositoryInterface;
use App\Exceptions\CodeGeneratorException;
use App\Models\Message;
use Stevebauman\Purify\Facades\Purify;

class MessageService
{
    public function __construct(
        protected MessageRepositoryInterface $messageRepository,
        protected LinkService $linkService
    ) {}

    /**
     * Create a new message
     *
     * @param  string  $content  The content of the message
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
     * Generate HTML content from Markdown for a message
     * @param Message $message
     * @return string The HTML content
     */
    public function generateHtmlContent(Message $message): string
    {
        // Convert Markdown content to HTML
        $htmlContent = new \Spatie\LaravelMarkdown\MarkdownRenderer()->toHtml($message->content);

        // Purify the HTML content
        return Purify::clean($htmlContent);
    }

    /**
     * Create a URL for accessing the message
     *
     * @param  Message  $message  The message to create a URL for
     * @return string The code of the created link
     *
     * @throws CodeGeneratorException
     */
    public function createCodeForMessage(Message $message): string
    {
        $link = $this->linkService->create(
            route('messages.show', ['message' => $message->id], false)
        );

        return $link->code;
    }
}
