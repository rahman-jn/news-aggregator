<?php

namespace App\Services;

use App\Interfaces\FetchNewsServiceInterface;
use App\Transformers\GuardianTransformer;
use App\Transformers\NewsApiTransformer;
use App\Transformers\NytimesTransformer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Source;
/*
 * @package Services
 * */
class FetchNewsService implements FetchNewsServiceInterface{

    public array $transformedNews;

    /**
     * Fetches raw news data from a specified source.
     *
     * @param Source $source The source from which to fetch news.
     *
     * @return array The raw news data.
     * @throws \Exception If an error occurs during the fetch process.
     */
    public function rawNews(Source $source): array
    {
        try {
            $response = Http::get($this->generateApiAddress($source));
            switch($source->name){
                case 'guardian':
                    return $response->json()['response']['results'];
                case 'nytimes':
                    return $response->json()['response']['docs'];
                case 'newsapi':
                    return $response->json()['articles']['results'];
            }

        }
        catch (\Exception $e){

            Log::error('Error fetching news from ' . $source->address . ': ' . $e->getMessage());

        }
        return (array) json_decode(
            response()->json(['error' => 'Failed to fetch news.'],500)
        );
    }

    /*
     * Transform fetched data to make standard and readable data for news table.
     *
     *  @urlParam news required unrefined fetched news.
     *  @urlParam sourcename required Source name of news.
     * */

    public function transform(array $news, string $sourceName): mixed
    {
        $this->transformedNews = array();

        foreach ($news as $newsItem) {
            switch ($sourceName) {
                case "guardian":
                {
                    $this->transformedNews[] = (new GuardianTransformer($newsItem))
                        ->getTransformedNews();
                    break;
                }
                case "nytimes":
                {
                    $this->transformedNews[] = (new NytimesTransformer($newsItem))
                        ->getTransformedNews();
                    break;
                }
                case "newsapi":
                {
                    $this->transformedNews[] = (new NewsApiTransformer($newsItem))
                        ->getTransformedNews();
                    break;
                }
                default:
                    throw new \Exception('Unexpected value');
            }
        }
        return $this->transformedNews;
    }

    /**
     * Generates the API address for the specified news source.
     *
     * @param Source $source The news source for which to generate the API address.
     *
     * @return string The generated API address.
     */
    private function generateApiAddress($source): string
    {
        switch ($source->name) {
            case "guardian":
                return "$source->address" . config('newsapi.guardianApiToken');
            case "nytimes":
                return $source->address . config('newsapi.nytimesApiToken');
            default:
                return $source->address . config('newsapi.newsApiToken');
        }
    }

}
