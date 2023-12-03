<?php

namespace App\Interfaces;
/**
 * @group Category Service
 *
 * APIs for managing categories.
 */
interface CategoryServiceInterface
{
    /**
     * Get Category ID.
     *
     * Retrieves the ID of a category based on the provided category name.
     *
     * @urlParam category_name string required The name of the category.
     *
     * @response {
     *     "category_id": 1
     * }
     *
     * @param string $categoryName
     * @return int
     */
    public function getCategoryId(string $categoryName): int;

    /**
     * Transform Category.
     *
     * Transforms the provided category name.
     *
     * @urlParam category string required The category name to transform.
     *
     * @response {
     *     "transformed_category": "Transformed Category"
     * }
     *
     * @param string $category
     * @return string
     */
    public function transformCategory(string $category): string;
}
