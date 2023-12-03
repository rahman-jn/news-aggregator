<?php

namespace App\Transformers;

use Carbon\Carbon;
use App\Interfaces\TransformerInterface;
use App\Services\CategoryService;


/**
 * Class NytimesTransformer
 *
 * @package Your\Namespace
 */
class NytimesTransformer implements TransformerInterface
{
    private string $title;
    private string $content;
    private string $url;
    private int $category_id;
    private array $authors;
    private array $images;
    private string $published_at;

    /**
     * NytimesTransformer constructor.
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
     * @param array            $newsItem         The array containing data of the news item.
     * @param CategoryService  $categoryService  Instance of CategoryService for category-related operations.
     *
     * @return void
     */
    public function transformNews(array $newsItem, CategoryService $categoryService): void
    {
        $this->title = $newsItem['headline']['main'];

        $this->content = $newsItem['abstract'];

        $this->url = $newsItem['web_url'];

        $this->category_id = $categoryService->getCategoryId($newsItem['section_name']);

        $this->authors = array_key_exists('byline', $newsItem) ?
            $this->getAuthors($newsItem['byline']['person']) : [];

        if (array_key_exists('multimedia', $newsItem))
            foreach ($newsItem['multimedia'] as $image) {

                $this->images[] = "https://nytimes.com/" . $image['url'];

            }

        $this->published_at = Carbon::parse($newsItem['pub_date']);

    }

    /**
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
     * @param array $byline The array containing author data.
     *
     * @return array The array of authors.
     */
    public function getAuthors($byline): array
    {
        $authors = [];

        foreach ($byline as $author) {

            $authors[]['name'] = $author['firstname'] . " " . $author['lastname'];

        }

        return $authors;
    }
}
