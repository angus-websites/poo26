<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Controller for handling messages
 */
class MessageController extends Controller
{
    public function __construct(
        protected MessageService $messageService,
    ) {}

    /**
     * Resolve a link and redirect to its target URL
     */
    public function show(Message $message): Factory|View
    {
        $content = $this->messageService->generateHtmlContent($message);

        return view('public.messages.show', compact('content'));
    }
}
