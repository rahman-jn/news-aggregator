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
 *
 * This model represents a Source with associated News.
 */
class Source extends Model
{
    use HasFactory;

    /**
     * Fillable attributes for mass assignment.
     *
     * @fillable [
     *     "name",
     *     "address",
     *     "active"
     * ]
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'active',
    ];

    /**
     * Get the News associated with the Source.
     *
     * @return HasMany
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
