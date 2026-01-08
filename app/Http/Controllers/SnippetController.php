<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SnippetController extends Controller
{
    /**
     * Resolve a link and redirect to its target URL
     */
    public function show(Snippet $snippet): Factory|View
    {
        return view('public.snippets.show', compact('snippet'));
    }
}
