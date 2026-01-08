<?php

namespace App\Repositories;

use App\Contracts\SnippetRepositoryInterface;
use App\Models\Snippet;
use Illuminate\Support\Collection;

class SnippetRepository implements SnippetRepositoryInterface
{
    public function create(array $data): Snippet
    {
        return Snippet::create($data);
    }

    public function findById(string $id): ?Snippet
    {
        return Snippet::find($id);
    }

    public function all(): Collection
    {
        return Snippet::all();
    }

    public function update(Snippet $snippet, array $data): Snippet
    {
        $snippet->update($data);
        return $snippet;
    }

    public function delete(Snippet $snippet): bool
    {
        return (bool) $snippet->delete();
    }
}
