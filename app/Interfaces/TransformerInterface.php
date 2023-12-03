<?php

namespace App\Interfaces;
use App\Services\CategoryService;

/**
 * @group Transformers
 *
 * This interface defines methods for transforming news items.
 */
interface TransformerInterface {

    /**
     * Transform a news item.
     *
     * @bodyParam newsItem array required The news item to be transformed.
     * @bodyParam categoryService CategoryService required An instance of CategoryService.
     * @response 204 {}
     *
     * @param array $newsItem The news item to be transformed.
     * @param CategoryService $categoryService An instance of CategoryService.
     *
     * @return void
     */
    public function transformNews(array $newsItem, CategoryService $categoryService): void;

    /**
     * Get the transformed news items.
     *
     * @response 200 {
     *    "news": [
     *       {
     *           "title": "Transformed News Title",
     *           "content": "Transformed News Content",
     *           "category_id": "Transformed Category",
     *           "url": "Transformed Url",
     *           "published_at": "Transformed Published date",
     *       },
     *    ]
     * }
     *
     * @return array The transformed news items.
     */
    public function getTransformedNews(): array;

    /**
     * Get authors based on the byline.
     *
     * @queryParam byline string required The byline for which authors need to be retrieved.
     * @response 200 {
     *    "authors": [
     *       "Author 1",
     *       "Author 2",
     *    ]
     * }
     *
     * @param string $byline The byline for which authors need to be retrieved.
     *
     * @return array The list of authors.
     */
    public function getAuthors(string $byline): array;
}

