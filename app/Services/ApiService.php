<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use App\Models\News;
use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Builder;

/**
 * @group Services
 *
 * This class implements ApiServiceInterface and provides methods for news searching.
 */
class ApiService implements ApiServiceInterface
{
    /**
     * Number of items to return in the search results.
     * @var int
     */
    public int $itemsCount = 10;

    /**
     * @param Request $request The request containing search parameters.
     *
     * @return array The array of news articles matching the search criteria.
     */

    public function newsSearch(Request $request): array
    {
        $query = News::select('news.id', 'news.title','content', 'news.url','published_at',
             'categories.name as category',
            \DB::raw('GROUP_CONCAT(DISTINCT COALESCE(images.url, ",")) as images'),
            \DB::raw('GROUP_CONCAT(DISTINCT COALESCE(authors.name, ",")) as authors')
            )

            ->join('images', 'news.id', '=', 'images.news_id')

            ->join('categories', 'news.category_id', '=', 'categories.id')

            ->join('news_authors', 'news_authors.news_id', '=', 'news.id')

            ->join('authors', 'news_authors.author_id', '=', 'authors.id')

            ->groupBy('news.id', 'news.title');


        $this->applyQueries($query, $request);

        $this->applyFilters($query, $request);

        $this->applyPreferences($query, $request);


        $modifiedResults = $query->limit($this->itemsCount)->get()->map(function ($item) {
            // Convert the comma-separated string to an array
            $item->images = explode(',', $item->images);

            $item->authors = explode(',', $item->authors);

            return $item;

        });

        // Convert the modified results to an array
        return $modifiedResults->toArray();


    }
    /**
     * @param Builder $query The news query builder.
     * @param Request $request The request containing filter parameters.
     *
     * @return Builder The modified news query builder.
     */
    private function applyFilters(Builder $query, Request $request)
    {
        $query->when($request->has('date'), function ($query) use ($request) {
            $query->where(\DB::raw('DATE(news.published_at)'), $request->date);
        });

        $query->when($request->has('category'), function ($query) use ($request) {
            $query->where('news.category_id', $request->category);
        });

        $query->when($request->has('source'), function ($query) use ($request) {
            $query->where('news.source_id', $request->source);
        });

        return $query;
    }

    /**
     * @param Builder $query The news query builder.
     * @param Request $request The request containing search parameters.
     *
     * @return void
     */
    private function applyQueries(Builder $query, Request $request): void
    {
        $query->when($request->has('q'), function ($query) use ($request) {

            return
                $query->where('news.title', 'LIKE', '%' . $request->q . '%')
                    ->orWhere('content', 'LIKE', '%' . $request->q . '%');

        });
    }

    /**
     *
     * @param Builder $query The news query builder.
     * @param Request $request The request containing user preference parameters.
     *
     * @return Builder The modified news query builder.
     */
    private function applyPreferences(Builder $query, Request $request)
    {
        $query->when($request->has('categories'), function ($query) use ($request) {
            $query->whereIn('news.category_id', explode(',', $request->categories));
        });

        $query->when($request->has('sources'), function ($query) use ($request) {
            $query->whereIn('news.source_id', explode(',', $request->sources));
        });

        $query->when($request->has('authors'), function ($query) use ($request) {
            $query->whereIn('news_authors.author_id', explode(',', $request->authors));
        });

        $query->when($request->has('from_date'), function ($query) use ($request) {
            $query->where(\DB::raw('DATE(news.published_at)'),'>', $request->from_date);
        });

        $query->when($request->has('to_date'), function ($query) use ($request) {
            $query->where(\DB::raw('DATE(news.published_at)'),'<', $request->to_date);
        });

        return $query;
    }
}
