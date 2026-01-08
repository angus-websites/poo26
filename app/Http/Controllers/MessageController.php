<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    /**
     * Resolve a link and redirect to its target URL
     */
    public function show(Message $message): Factory|View
    {
        return view('public.messages.show', compact('message'));
    }
}
