<?php

namespace App\Models;

use Database\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Represents a message entity.
 *
 * @property string $id
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Message extends Model
{
    /** @use HasFactory<MessageFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'content',
    ];
}
