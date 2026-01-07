<?php
namespace App\Repositories;

use App\Contracts\MessageRepositoryInterface;
use App\Models\Message;
use Illuminate\Support\Collection;

class MessageRepository implements MessageRepositoryInterface
{

    public function create(array $data): Message
    {
        return Message::create($data);
    }

    public function findById(string $id): ?Message
    {
        return Message::find($id);
    }

    public function all(): Collection
    {
        return Message::all();
    }

    public function update(Message $message, array $data): Message
    {
        $message->update($data);
    }

    public function delete(Message $message): bool
    {
        return (bool)$message->delete();
    }
}
