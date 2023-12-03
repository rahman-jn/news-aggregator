<?php

namespace App\Services;

use App\Interfaces\CategoryServiceInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

/**
 * @group Services
 *
 * This class implements CategoryServiceInterface and provides methods for handling categories.
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * @urlParam categoryName string required The name of the category.
     * @response 200 {
     *    "category_id": 1
     * }
     *
     * @param string $categoryName The name of the category.
     *
     * @return int The ID of the category.
     */
    public function getCategoryId(string $categoryName): int
    {
        return Category::where('name', $this->transformCategory($categoryName))->first()->id;
    }

    /**
     * Transform a category names to existed categories name.
     *
     * @urlParam category string required The original name of the category.
     * @response 200 {
     *    "transformed_category": "politics"
     * }
     *
     * @param string $category The original name of the category.
     *
     * @return string The transformed category name.
     */
    public function transformCategory(string $category): string
    {

        switch($category){
            case in_array($category,["politics"]):{
                return 'politics';
            }
            case "environment":{
                return 'environment';
            }
            case "business":{
                return 'business';
            }
            case in_array($category,["news", "world", "uk-news"]):{
                return 'world';
            }
            case in_array($category,["football", "sport", "basketball"]):{
                return 'sport';
            }
            case in_array($category,["U.S", "us-news"]):{
                return 'usa';
            }
            default: {
                return 'general';
            }
        }
    }
}
