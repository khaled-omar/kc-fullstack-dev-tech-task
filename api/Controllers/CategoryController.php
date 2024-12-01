<?php

require_once __DIR__ . '/../Models/Category.php';

class CategoryController
{
    public static function index()
    {
        $categories = Category::getCategoryTreeWithCourses();
        echo json_encode($categories);
    }

    public static function show(string $id)
    {
        $category = Category::findById($id);
        echo json_encode($category);
    }
}
