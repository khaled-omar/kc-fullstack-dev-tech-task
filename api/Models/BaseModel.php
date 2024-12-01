<?php

use Libs\Database;

require_once __DIR__ . '/../Libs/Database.php';

abstract class BaseModel
{
    public static function findAll()
    {
        $conn = Database::getConnection();
        // Concatenate the table name into the query string
        $query = "SELECT * FROM " . static::$table;
        $stmt  = $conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findById($id)
    {
        $database = new Database();
        $conn     = $database->getConnection();

        $query = "SELECT * FROM " . static::$table . " WHERE id = :id";
        $stmt  = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
