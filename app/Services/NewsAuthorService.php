<?php

namespace App\Services;

use App\Interfaces\NewsAuthorServiceInterface;
use App\Models\Author;
use App\Models\NewsAuthor;
use Illuminate\Support\Facades\Log;

/**
 * Class NewsAuthorService
 *
 * @package App\Services
 * @group Services
 */
class NewsAuthorService implements NewsAuthorServiceInterface
{
    /**
     * Creates a news author and associates them with a news article.
     *
     * @param array $authorName An associative array containing the author's name and optional email.
     * @param int   $newsId     The ID of the news article to associate the author with.
     *
     * @return NewsAuthor The created or existing NewsAuthor instance.
     */
    public function createNewsAuthor(array $authorName, int $newsId): NewsAuthor
    {
        $author = Author::whereName($authorName['name'])->firstOrCreate([
            'name' => $authorName['name'],
            'email' => $authorName['email'] ?? null
        ]);

        return NewsAuthor::firstOrCreate([
            'author_id' => $author['id'],
            'news_id' => $newsId
        ]);
    }
}

