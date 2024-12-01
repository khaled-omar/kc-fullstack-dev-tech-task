<?php

use Libs\Database;

require_once __DIR__.'/../../api/Database.php';


function seedCourses() {
    // Load courses data from JSON
    $json = file_get_contents(__DIR__ . '/../../data/course_list.json');
    $courses = json_decode($json, true);

    // Database connection
    $database = new Database();
    $conn = $database->getConnection();

    try {
        $conn->beginTransaction();

        // Insert courses
        $query = "INSERT INTO courses (id, title, description, image_preview, category_id, created_at, updated_at) 
                  VALUES (:id, :title, :description, :image_preview, :category_id, NOW(), NOW())";
        $stmt = $conn->prepare($query);

        foreach ($courses as $course) {
            $stmt->bindParam(':id', $course['course_id']);
            $stmt->bindParam(':title', $course['title']);
            $stmt->bindParam(':description', $course['description']);
            $stmt->bindParam(':image_preview', $course['image_preview']);
            $stmt->bindParam(':category_id', $course['category_id']);
            $stmt->execute();
        }

        $conn->commit();
        echo "Courses seeded successfully.\n";
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Failed to seed courses: " . $e->getMessage() . "\n";
    }
}

// Run the function
seedCourses();

