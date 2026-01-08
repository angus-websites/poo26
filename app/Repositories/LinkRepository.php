<?php

namespace App\Repositories;

use App\Contracts\LinkRepositoryInterface;
use App\Models\Link;
use Illuminate\Support\Collection;

class LinkRepository implements LinkRepositoryInterface
{
    public function create(array $data): Link
    {
        return Link::create($data);
    }

    public function findById(int $id): ?Link
    {
        return Link::find($id);
    }

    public function findBySlug(string $slug): ?Link
    {
        return Link::where('slug', $slug)
            ->first();
    }

    public function findPermanentByHash(string $hash): ?Link
    {
        return Link::permanent()
            ->where('url_hash', $hash)
            ->first();
    }

    public function all(): Collection
    {
        return Link::all();
    }

    public function update(Link $link, array $data): Link
    {
        $link->update($data);

        return $link;
    }

    public function delete(Link $link): bool
    {
        return (bool) $link->delete();
    }


}
