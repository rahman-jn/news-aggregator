<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 */

/**
 * @group Models
 */
class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'active',
    ];

    /**
     * Get the NewsAuthors associated with the Author.
     *
     * @return HasMany
     */
    public function newsAuthor(): HasMany
    {
        return $this->hasMany(NewsAuthor::class);
    }
}

