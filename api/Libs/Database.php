<?php

namespace Libs;

use PDO;
use PDOException;

class Database
{
    const HOST = "database.cc.localhost";

    const DB_NAME = "course_catalog";

    const USERNAME = "test_user";

    const PASSWORD = "test_password";

    public static function getConnection()
    {
        try {
            $conn = new PDO(
                "mysql:host=" . static::HOST . ";dbname=" . static::DB_NAME,
                static::USERNAME,
                static::PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
            die;
        }

        return $conn;
    }
}
