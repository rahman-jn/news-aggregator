<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 */

/**
 * @group Models
 *
 */
class News extends Model
{
    use HasFactory;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'url',
        'category_id',
        'source_id',
        'active',
        'published_at',
    ];

    /**
     * Get the Source associated with the News.
     *
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * Get the Category associated with the News.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the Images associated with the News.
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the NewsAuthors associated with the News.
     *
     * @return HasMany
     */
    public function newsAuthor(): HasMany
    {
        return $this->hasMany(NewsAuthor::class);
    }
}

