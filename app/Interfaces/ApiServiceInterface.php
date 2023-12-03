<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

/**
 * @group API Service
 *
 * APIs for interacting with external services.
 */
interface ApiServiceInterface
{
    /**
     * Search for news.
     *
     * Searches for news based on the provided search parameters.
     *
     * @queryParam q string required The keyword to search for news.
     * @queryParam category string The category to filter news by.
     * @queryParam from_date date The starting date for news search (YYYY-m-m).
     * @queryParam to_date date The ending date for news search (YYYY-m-m).
     *
     * @response {
     *      [
     *         {
     *             "id": 1,
     *             "title": "News Title",
     *             "content": "News Content",
                   "category" : "world",
     *             "published_at": "2023-04-10T12:00:00Z",
     *             "images": [
     *                         "image_url1.jpg",
     *                          "image_url2.jpg",
     *                      ],
     *              "authors": [
     *                          "Jhon Due",
     *                           "Rahman Jafarinejad",
     *                       ],
     *         },
     *     ],
     *     "links": {
     *          "queries" : "http://localhost:8000/api/news/search?q=example",
     *          "filters" : "http://localhost:8000/api/news/search?author=1&
 *                              category=2&source=1&date=2023-12-02",
     *         "preferences": "http://localhost:8000/api/news/
 *                      search?authors=1,2&categories=1,2,3&
     *                  sources=1,2&
     *                  from_date=2023-12-01&to-date=2023-12-04"
     *     }
     * }
     *
     * @param Request $request
     * @return array
     */
    public function newsSearch(Request $request): array;
}
