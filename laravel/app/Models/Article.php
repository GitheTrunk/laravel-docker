<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Article extends Model
{
    //
    protected $fillable = ['name', 'author_id'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function audiences(): HasMany
    {
        return $this->hasMany(Audience::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'article_user')->withTimestamps();
    }
}
