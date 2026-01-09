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

    public function findByCode(string $code): ?Link
    {
        return Link::where('code', $code)->first();
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
        return $link->delete();
    }
}
