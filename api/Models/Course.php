<?php

use Libs\Database;

require_once __DIR__ . '/../Libs/Database.php';
require_once __DIR__ . '/BaseModel.php';

class Course extends BaseModel
{
    protected static $table = 'courses';

    public static function findByCategoryId(string $categoryId) {
        $database = new Database();
        $conn = $database->getConnection();

        // Get all child category IDs, including the parent
        $categoryIds = Category::getAllCategoryIds($categoryId);  // Implemented in Category model
        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));  // Dynamic placeholders

        // Updated query to select courses for all categories
        $query = "SELECT * FROM " . static::$table . " WHERE category_id IN ($placeholders)";
        $stmt = $conn->prepare($query);

        // Bind parameters dynamically
        $stmt->execute($categoryIds);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }
}
