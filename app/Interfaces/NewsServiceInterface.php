<?php

namespace App\Interfaces;

use App\Models\News;
use Illuminate\Database\Eloquent\Collection;

Interface NewsServiceInterface {
    public function createNews(array $data, int $sourceId): void;
}
