<?php

namespace App\Interfaces;

use App\Models\Image;

Interface ImageRepositoryInterface {
    public function store(string $image, int $newsId): Image;
}
