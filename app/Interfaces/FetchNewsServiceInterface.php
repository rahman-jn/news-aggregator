<?php
namespace App\Interfaces;
use App\Models\Source;

/**
 * @group News Service
 *
 * APIs for fetching and transforming news data.
 */
interface FetchNewsServiceInterface
{
    /**
     * Get Raw News Data.
     *
     * Retrieves raw news data from the provided news source.
     *
     * @urlParam source_id integer required The ID of the news source.
     *
     * @response {
     *     "raw_news": [
     *         {
     *              Each source structure is different from others.
     *         }
     *     ]
     * }
     *
     * @param Source $source
     * @return array
     */
    public function rawNews(Source $source): array;

    /**
     * Transform Raw News Data.
     *
     * Transforms raw news data based on the provided source name.
     *
     * @urlParam source_name string required The name of the news source.
     *
     * @response {
     *     "transformed_news": [
     *         {
     *             "title": "Transformed Title",
     *             "content": "Transformed Summary",
     *             "url": "https://source_news_url",
     *             "category_id": "2",
     *             "source_id": "1",
     *             "published_at": "2023-04-10T12:00:00Z",
     *             // More transformed news data
     *         },
     *         // More transformed news entries
     *     ]
     * }
     *
     * @param array $news
     * @param string $sourceName
     * @return mixed
     */
    public function transform(array $news, string $sourceName): mixed;
}

