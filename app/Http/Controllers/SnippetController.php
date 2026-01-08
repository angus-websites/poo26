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
        // Convert Markdown content to HTML
        $code = $snippet->content;
        $language = $snippet->language ?? 'plaintext';
        $htmlContent = '<pre><code class="language-' . e($language) . '">' . e($code) . '</code></pre>';

        return view('public.snippets.show', compact('snippet', 'htmlContent'));
    }
}
