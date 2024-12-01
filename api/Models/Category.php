<?php

use Libs\Database;

require_once __DIR__ . '/../Libs/Database.php';
require_once __DIR__ . '/BaseModel.php';

class Category extends BaseModel
{
    protected static $table = 'categories';

    public static function getCategoryTreeWithCourses(): array
    {
        $categories = static::findAll();
        $courses    = static::getCoursesGroupedByCategory();

        $categoryMap = [];

        foreach ($categories as $category) {
            $category['count_of_courses']     = 0;
            $category['children']         = [];
            $categoryMap[$category['id']] = $category;
        }

        foreach ($courses as $course) {
            $categoryId = $course['category_id'];
            if (isset($categoryMap[$categoryId])) {
                $categoryMap[$categoryId]['count_of_courses'] = $course['count_of_courses'];
            }
        }

        $categoryTree = [];
        foreach ($categoryMap as $id => &$category) {
            if ($category['parent_id']) {
                $categoryMap[$category['parent_id']]['children'][] = &$category;
            } else {
                $categoryTree[] = &$category;
            }
        }

        self::calculateTotalCourses($categoryTree);

        return $categoryTree;
    }

    // Fetch all courses grouped by category_id
    protected static function getCoursesGroupedByCategory()
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT category_id, COUNT(*) AS count_of_courses FROM courses GROUP BY category_id");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function calculateTotalCourses(&$categories)
    {
        foreach ($categories as &$category) {
            $totalCourses = $category['count_of_courses'];

            if (! empty($category['children'])) {
                $totalCourses += self::calculateTotalCourses($category['children']);
            }

            $category['count_of_courses'] = $totalCourses;
            $category['children']  = array_values($category['children']);
        }

        return array_sum(array_column($categories, 'count_of_courses'));
    }


    // Fetch all categories from the database
    public static function getAllCategories() {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT id, parent_id FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all category IDs recursively, including children
    public static function getAllCategoryIds($parentId) {
        $categories = self::getAllCategories();
        $categoryIds = [$parentId];

        self::collectChildCategoryIds($parentId, $categories, $categoryIds);

        return $categoryIds;
    }

    // Recursive helper function to find child IDs
    private static function collectChildCategoryIds($parentId, $categories, &$categoryIds) {
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $categoryIds[] = $category['id'];
                self::collectChildCategoryIds($category['id'], $categories, $categoryIds);
            }
        }
    }
}
