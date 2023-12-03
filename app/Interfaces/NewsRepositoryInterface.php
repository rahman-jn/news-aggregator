<?php

namespace App\Interfaces;

Interface NewsRepositoryInterface {
    public function getByUrl(string $url);
}
