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

enum FetchNewsSource :string {
    case Guardian = 'guardian';
    case NyTimes = 'nytimes';
    case NewsApi = 'newsapi';
}

class FetchNewsService implements FetchNewsServiceInterface {

    public array $transformedNews;

    public function rawNews(Source $source): array {
        $response = Http::get($this->generateApiAddress($source));

        return match (FetchNewsSource::from($source->name)) {
            FetchNewsSource::Guardian => $response->json()['response']['results'],
            FetchNewsSource::NyTimes => $response->json()['response']['docs'],
            FetchNewsSource::NewsApi => $response->json()['articles']['results'],
        };
    }

    public function transform(array $news, string $sourceName): mixed {
        $this->transformedNews = [];

        foreach ($news as $newsItem) {
            try {
                $transformer = match (FetchNewsSource::from($sourceName)) {
                    FetchNewsSource::Guardian => new GuardianTransformer($newsItem),
                    FetchNewsSource::NyTimes => new NytimesTransformer($newsItem),
                    FetchNewsSource::NewsApi => new NewsApiTransformer($newsItem),
                };

                $this->transformedNews[] = $transformer->getTransformedNews();
            }
            catch (\Exception $e) {
            // Log the exception
            Log::error('Exception in transform loop: ' . $e->getMessage());
        }
        }


        return $this->transformedNews;
    }

    private function generateApiAddress(Source $source): string
    {
        return match (FetchNewsSource::from($source->name)) {
            FetchNewsSource::Guardian => $source->address . config('newsapi.guardianApiToken'),
            FetchNewsSource::NyTimes => $source->address . config('newsapi.nytimesApiToken'),
            FetchNewsSource::NewsApi => $source->address . config('newsapi.newsApiToken'),
        };
    }

}

