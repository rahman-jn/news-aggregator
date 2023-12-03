<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @group Models
 */
class Image extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'url',
        'news_id',
        'active',
    ];

    /**
     * Get the News associated with the Image.
     *
     * @return BelongsTo
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}

