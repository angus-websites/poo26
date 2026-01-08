<?php

namespace App\Services;

use App\Contracts\SnippetRepositoryInterface;
use App\Exceptions\SlugException;
use App\Models\Snippet;
use Spatie\ShikiPhp\Shiki;

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
    public function create(string $content, ?string $language = null): Snippet
    {
        return $this->snippetRepository->create([
            'content' => $content,
            'language' => $language,
        ]);
    }

    /**
     * Generate HTML content for a snippet with syntax highlighting
     *
     * @param  Snippet  $snippet  The snippet model
     * @return string The HTML content with syntax highlighting
     */
    public function generateHtmlContent(Snippet $snippet): string
    {
        return Shiki::highlight(
            code: $snippet->content,
            language: $snippet->language,
            theme: config('snippets.themes')
        );
    }

    /**
     * Get the human-readable name of a programming language
     * If not found, return the original language code
     *
     * @return string The human-readable name of the programming language
     */
    public function getLanguageName(string $languageCode): string
    {
        return collect(config('snippets.languages'))
            ->flatMap(fn ($group) => $group)
            ->get($languageCode)['label']
            ?? $languageCode;

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
