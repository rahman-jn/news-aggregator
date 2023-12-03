<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


    /**
     * @group Models
     *
     * This model represents a relationship between News and Author.
     */
class NewsAuthor extends Model
{
    use HasFactory;
    /**
     * Fillable attributes for mass assignment.
     *
     * @fillable [
     *     "news_id",
     *     "author_id",
     *     "active"
     * ]
     *
     * @var array
     */
    protected $fillable = [
        'news_id',
        'author_id',
        'active',
    ];

    /**
     * Get the author associated with the NewsAuthor.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the news associated with the NewsAuthor.
     *
     * @return BelongsTo
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}

