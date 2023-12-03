<?php

namespace App\Repositories;

use App\Interfaces\NewsRepositoryInterface;
use App\Models\News;

/**
 * @group Repositories
 *
 * This class implements News repository methods.
 */
class NewsRepository implements NewsRepositoryInterface
{
    /**
     * Get a news article by its URL.
     *
     * @urlParam url string required The URL of the news article.
     * @response 200 {
     *    "id": 123,
     *    "title": "News Title",
     *    "content": "News Content",
     *    "url": "News URL",
     *    "category_id": 1,
     *    "source_id": 2,
     *    "active": true,
     *    "published_at": "2023-01-01 12:00:00",
     *    "created_at": "2023-01-01 12:00:00",
     *    "updated_at": "2023-01-01 12:00:00"
     * }
     *
     * @param string $url The URL of the news article.
     *
     * @return mixed The news article or null if not found.
     */
    public function getByUrl(string $url)
    {
        return News::whereUrl($url)->first();
    }
}
