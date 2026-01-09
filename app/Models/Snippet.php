<?php

namespace App\Models;

use Database\Factories\SnippetFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Represents a code snippet entity.
 *
 * @property string $id
 * @property string|null $language
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[UseFactory(SnippetFactory::class)]
class Snippet extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'language',
        'content',
    ];
}
