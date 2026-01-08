<?php

namespace App\Repositories;

use App\Contracts\LinkRepositoryInterface;
use App\Models\Destination;
use Illuminate\Support\Collection;

class LinkRepository implements LinkRepositoryInterface
{
    public function create(array $data): Destination
    {
        return Destination::create($data);
    }

    public function findById(int $id): ?Destination
    {
        return Destination::find($id);
    }

    public function findByHash(string $hash): ?Destination
    {
        return Destination::where('url_hash', $hash)
            ->first();
    }

    public function all(): Collection
    {
        return Destination::all();
    }

    public function update(Destination $link, array $data): Destination
    {
        $link->update($data);

        return $link;
    }

    public function delete(Destination $link): bool
    {
        return (bool) $link->delete();
    }
}
