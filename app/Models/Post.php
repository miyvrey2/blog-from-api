<?php

namespace App\Models;

use App\TracksUpdates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'author_id'
    ];

    protected $with = ['author'];

    public function author(): BelongsTo
    {
        return $this->BelongsTo(Author::class);
    }

    public function comments(): HasMany
    {
        return $this->HasMany(Comment::class);
    }
}
