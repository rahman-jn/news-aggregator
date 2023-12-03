<?php

namespace App\Transformers;

use App\Interfaces\CategoryServiceInterface;
use Carbon\Carbon;
use App\Interfaces\TransformerInterface;
use App\Services\CategoryService;


/**
 * Class GuardianTransformer
 * @group Transformers
 * @package App\Transformers
 */
class GuardianTransformer implements TransformerInterface
{
    private string $title;

    private string $content;

    private string $url;

    private int $category_id;

    private array $authors;

    private array $images;

    private string $published_at;

    /**
     * GuardianTransformer constructor.
     *
     * @param array            $newsItem         The array containing data of the news item.
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
        $this->title = $newsItem['webTitle'];

        $this->content = $newsItem['fields']['bodyText'];

        $this->url = $newsItem['webUrl'];

        $this->category_id = $categoryService->getCategoryId($newsItem['sectionId']);

        $this->authors = array_key_exists('byline', $newsItem['fields']) ?
            $this->getAuthors($newsItem['fields']['byline']) : [];

        $this->images[0] = array_key_exists('thumbnail', $newsItem['fields']) ?
            $newsItem['fields']['thumbnail'] : [];

        $this->published_at = Carbon::parse($newsItem['fields']['firstPublicationDate'])
            ->format('Y-m-d');
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
     * Get an array of authors from the provided byline string.
     *
     * @param string $byline The byline string containing author names.
     *
     * @return array The array of authors.
     */
    public function getAuthors(string $byline): array
    {
        $authors = [];

        if ($byline) {
            $bylines = explode(',', $byline);

            foreach ($bylines as $byline) {
                $authors[] = ['name' => $byline];
            }

        }
        return $authors;
    }
}
