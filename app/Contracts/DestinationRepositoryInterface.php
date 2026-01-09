<?php

namespace App\Contracts;

use App\Models\Destination;
use Illuminate\Support\Collection;

interface DestinationRepositoryInterface
{
    /**
     * Create a new destination model
     */
    public function create(array $data): Destination;

    /**
     * Find a destination by ID.
     */
    public function findById(int $id): ?Destination;

    /**
     * Find a destination by the hash of the URL.
     */
    public function findByHash(string $hash): ?Destination;

    /**
     * Get all destinations
     */
    public function all(): Collection;

    /**
     * Update a destination.
     */
    public function update(Destination $destination, array $data): Destination;

    /**
     * Delete a destination.
     */
    public function delete(Destination $destination): bool;
}
