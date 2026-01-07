<?php


namespace App\Contracts;

use App\Models\Message;
use Illuminate\Support\Collection;

interface MessageRepositoryInterface
{
    /**
     * Create a new message.
     */
    public function create(array $data): Message;

    /**
     * Find a message by UUID.
     */
    public function findById(string $id): ?Message;

    /**
     * Get all messages.
     */
    public function all(): Collection;

    /**
     * Update a message.
     */
    public function update(Message $message, array $data): Message;

    /**
     * Delete a message.
     */
    public function delete(Message $message): bool;
}
