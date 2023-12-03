<?php

namespace App\Http\Controllers;

use App\Interfaces\ApiServiceInterface;
use App\Interfaces\FetchNewsServiceInterface;
use App\Interfaces\NewsServiceInterface;
use App\Models\Source;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group News Management
 *
 * APIs for managing news data.
 */
class NewsController extends Controller
{
    /**
     * Fetches news data from sources Api and store them in database.
     *
     * @urlParam source_id integer required The ID of the news source.
     *
     * @response {
     *     "success": true,
     *     "message": "News fetched and stored successfully."
     * }
     *
     * @param FetchNewsServiceInterface $fetchNewsService
     * @param NewsServiceInterface $newsService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(FetchNewsServiceInterface $fetchNewsService, NewsServiceInterface $newsService)
    {
        try {
            $sources = Source::whereActive(1)->get();
            foreach ($sources as $source) {
                //Each source returns data on its own format.
                $rawNews = $fetchNewsService->rawNews($source);

                //Transform data to have same structure for all resources' news
                $transformedNews = $fetchNewsService->transform($rawNews, $source->name);

                //Store transformed data to database
                $newsService->createNews($transformedNews, $source->id);
            }

            return response()->json(['success' => true, 'message' => 'News fetched and stored successfully.']);
        }
        catch (\Exception $e){
            Log::error("Error happend while trying to fetch and store news". $e);
        }
    }

    /**
     * @group News EndPoint Api
     *
     * Search on news.
     *
     * Searches for news based on the provided search parameters.
     *
     * @queryParam q string The keyword to search for news.
     * @queryParam category string The category to filter news by.
     * @queryParam from_date date The starting date for news search (YYYY-MM-DD).
     * @queryParam to_date date The ending date for news search (YYYY-MM-DD).
     *
     * @param Request $request
     * @param ApiServiceInterface $apiService
     * @return mixed
     */
    public function search(Request $request, ApiServiceInterface $apiService)
    {
        return $apiService->newsSearch($request);
    }
}

