<?php

namespace App\Repositories;

use App\Contracts\LinkRepositoryInterface;
use App\Data\LinkData;
use App\Models\Link;
use Illuminate\Support\Collection;

class LinkRepository implements LinkRepositoryInterface
{
    public function create(LinkData $data): Link
    {
        return Link::create($data->toArray());
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
        return (bool)$link->delete();
    }
}
