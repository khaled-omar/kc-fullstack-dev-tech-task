<?php

use Libs\Database;

require_once __DIR__.'/../../api/Database.php';

function seedCategories() {
    // Load categories data from JSON
    $json = file_get_contents(__DIR__ . '/../../data/categories.json');
    $categories = json_decode($json, true);

    // Database connection
    $database = new Database();
    $conn = $database->getConnection();

    try {
        $conn->beginTransaction();

        // Insert categories
        $query = "INSERT INTO categories (id, name, parent_id) VALUES (:id, :name, :parent_id)";
        $stmt = $conn->prepare($query);

        foreach ($categories as $category) {
            $stmt->bindParam(':id', $category['id']);
            $stmt->bindParam(':name', $category['name']);
            $stmt->bindParam(':parent_id', $category['parent']); // 'parent' can be null
            $stmt->execute();
        }

        $conn->commit();
        echo "Categories seeded successfully.\n";
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Failed to seed categories: " . $e->getMessage() . "\n";
    }
}

// Run the function
seedCategories();

