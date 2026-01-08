<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use App\Services\SnippetService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SnippetController extends Controller
{

    public function __construct(
        protected SnippetService $snippetService
    )
    {}

    /**
     * Resolve a link and redirect to its target URL
     */
    public function show(Snippet $snippet): Factory|View
    {
        $htmlContent = $this->snippetService->generateHtmlContent($snippet);
        $rawContent = $snippet->content;
        $languageName = $this->snippetService->getLanguageName($snippet->language);

        return view('public.snippets.show', [
            'htmlContent' => $htmlContent,
            'languageName' => $languageName,
            'rawContent' => $rawContent,
        ]);
    }
}
