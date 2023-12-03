<?php

namespace App\Transformers;

use Carbon\Carbon;
use App\Interfaces\TransformerInterface;
use App\Services\CategoryService;

/**
 * Class NewsApiTransformer
 * @group Transformers
 * @package App\Transformers
 */
class NewsApiTransformer implements TransformerInterface
{
    private string $title;

    private string $content;

    private string $url;

    private int $category_id;

    private array $authors;

    private array $images;

    private string $published_at;

    /**
     * NewsApiTransformer constructor.
     *
     * @param array            $newsItem         The array containing data of the news item.
     * @param CategoryService  $categoryService  Instance of CategoryService for category-related operations.
     */
    public function __construct(array $newsItem)
    {
        $categoryService = new   categoryService();

        $this->transformNews($newsItem, $categoryService);
    }

    /**
     * Transform the provided news data and populate the class properties.
     *
     * @param array            $newsItem         The array containing data of the news item.
     * @param CategoryService  $categoryService  Instance of CategoryService for category-related operations.
     *
     * @return void
     */
    public function transformNews(array $newsItem, CategoryService $categoryService): void
    {
        $this->title = $newsItem['title'];

        $this->content = $newsItem['body'];

        $this->url = $newsItem['url'];

        $this->category_id = $categoryService->getCategoryId($newsItem['dataType']);

        $this->authors = array_key_exists('authors', $newsItem) ?
            $this->getAuthors($newsItem['authors']) : [];

        $this->images[0] = array_key_exists('image', $newsItem) ?
             $newsItem['image'] :[];

        $this->published_at = Carbon::parse($newsItem['dateTimePub']);
    }

    /**
     * Get the transformed news data as an associative array.
     *
     * @return array The transformed news data.
     */
    public function getTransformedNews(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'url' => $this->url,
            'category_id' => $this->category_id,
            'authors' => $this->authors,
            'images' => $this->images,
            'published_at' => $this->published_at,
        ];
    }

    /**
     * Get an array of authors from the provided byline array.
     *
     * @param array $byline The array containing author data.
     *
     * @return array The array of authors.
     */
    public function getAuthors($byline): array
    {
        $authors = [];

        foreach ($byline as $author) {

            $authors[] = [
                'name' => $author['name'],
                'email' => $author['uri'],
            ];

        }

        return $authors;
    }
}
