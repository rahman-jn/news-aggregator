<?php

namespace App\Interfaces;

use App\Models\NewsAuthor;

Interface NewsAuthorServiceInterface{
    public function createNewsAuthor(array $authorName, int $newsId): NewsAuthor;
}
