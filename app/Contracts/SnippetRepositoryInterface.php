<?php

namespace App\Contracts;

use App\Models\Snippet;
use Illuminate\Support\Collection;

interface SnippetRepositoryInterface
{
    /**
     * Create a new snippet.
     */
    public function create(array $data): Snippet;

    /**
     * Find a snippet by UUID.
     */
    public function findById(string $id): ?Snippet;

    /**
     * Get all snippets.
     */
    public function all(): Collection;

    /**
     * Update a snippet.
     */
    public function update(Snippet $snippet, array $data): Snippet;

    /**
     * Delete a snippet.
     */
    public function delete(Snippet $snippet): bool;
}
