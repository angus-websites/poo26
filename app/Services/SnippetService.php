<?php

namespace App\Services;

use App\Contracts\SnippetRepositoryInterface;
use App\Exceptions\SlugException;
use App\Models\Snippet;

class SnippetService
{
    public function __construct(
        protected SnippetRepositoryInterface $snippetRepository,
        protected LinkService $linkService
    ) {}

    /**
     * Create a new snippet
     *
     * @param  string  $content  The content of the message
     * @param  string|null  $language  The programming language of the snippet (optional)
     */
    public function create(string $content, ?string $language): Snippet
    {
        return $this->snippetRepository->create([
            'content' => $content,
            'language' => $language,
        ]);
    }

    /**
     * Create a URL for accessing the snippet
     *
     * @param  Snippet  $snippet  The snippet model to create the link for
     * @return string The slug of the created link
     *
     * @throws SlugException
     */
    public function createSlugForSnippet(Snippet $snippet): string
    {
        $link = $this->linkService->create(
            route('snippets.show', ['snippet' => $snippet->id], false)
        );

        return $link->slug;
    }
}
