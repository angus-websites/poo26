<?php

namespace App\Repositories;

use App\Contracts\DestinationRepositoryInterface;
use App\Models\Destination;
use Illuminate\Support\Collection;

class DestinationRepository implements DestinationRepositoryInterface
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
        return Destination::where('url_hash', $hash)->first();
    }

    public function all(): Collection
    {
        return Destination::all();
    }

    public function update(Destination $destination, array $data): Destination
    {
        $destination->update($data);

        return $destination;
    }

    public function delete(Destination $destination): bool
    {
        return $destination->delete();
    }
}
