<?php

namespace App\Repositories;

use App\Interfaces\ImageRepositoryInterface;
use App\Models\Image;

/**
 * @group Repositories
 *
 * This class implements Image repository methods.
 */
class ImageRepository implements ImageRepositoryInterface
{
    /**
     * Store an image for a news article.
     *
     * @urlParam image string required The URL of the image.
     * @urlParam newsId int required The ID of the news article.
     * @response 200 {
     *    "url": "Stored Image URL",
     *    "news_id": 123,
     *    "active": true,
     *    "created_at": "2023-01-01 12:00:00",
     *    "updated_at": "2023-01-01 12:00:00"
     * }
     *
     * @param string $image The URL of the image.
     * @param int $newsId The ID of the news article.
     *
     * @return Image The stored image.
     */
    public function store(string $image, int $newsId): Image
    {
        return Image::firstOrCreate([
            'url' => $image,
            'news_id' => $newsId,
        ]);
    }
}
