<?php

namespace App\Services;

use App\Interfaces\NewsAuthorServiceInterface;
use App\Interfaces\NewsServiceInterface;
use App\Models\News;
use App\Repositories\ImageRepository;
use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;
/**
 * Class NewsService
 * @group Services
 * @package App\Services
 */
class NewsService implements NewsServiceInterface
{
    private ImageRepository $imageRepository;

    private NewsAuthorServiceInterface $newsAuthorService;

    private NewsRepository $newsRepository;


    public function __construct( ) {
        $this->imageRepository = new imageRepository();
        $this->newsAuthorService = new NewsAuthorService();
        $this->newsRepository = new newsRepository();
    }

    /**
     * Creates news articles from the provided data and associates them with the specified source.
     *
     * @param array $data      An array containing news data.
     * @param int   $sourceId  The ID of the news source.
     *
     * @return void
     */
    public function createNews(array $data, int $sourceId): void
    {
        try {
            foreach ($data as $newsItem) {
                $existingNews = $this->newsRepository->getByUrl($newsItem['url']);
                if (!$existingNews) {
                    $newNews = News::create([
                        'title' => $newsItem['title'],
                        'content' => substr(Purifier::clean($newsItem['content']), 200),
                        'category_id' => $newsItem['category_id'],
                        'url' => $newsItem['url'],
                        'source_id' => $sourceId,
                        'published_at' => $newsItem['published_at'],
                    ]);

                    foreach ($newsItem['images'] as $image) {
                        if ($image) {
                            $this->imageRepository->store($image, $newNews->id);
                        }
                    }

                    foreach ($newsItem['authors'] as $author) {
                        if (array_key_exists('name', $author)) {
                            $this->newsAuthorService->createNewsAuthor($author, $newNews->id);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Error in inserting news data to database\n. $e");
        }
    }
}
