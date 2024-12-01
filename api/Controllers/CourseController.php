<?php

require_once __DIR__ . '/../Models/Course.php';

class CourseController
{
    public static function index($queryParams = [])
    {
        $categories = isset($queryParams['category_id']) ? Course::findByCategoryId($queryParams['category_id']) : Course::findAll();
        echo json_encode($categories);
    }

    public static function show(string $id)
    {
        $category = Course::findById($id);
        echo json_encode($category);
    }
}
