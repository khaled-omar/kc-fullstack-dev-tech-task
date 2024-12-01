<?php

use Libs\Database;

require_once 'Database.php';

const MIGRATION_PATH = __DIR__ . '/../database/migrations/';


$pdo = (new Database())->getConnection();


// Function to apply or rollback migrations
function runMigration($pdo, $path, $direction)
{
    $sql = file_get_contents($path);
    $queries = explode('-- down', $sql);
    $query = $direction === 'up' ? $queries[0] : $queries[1];
    $pdo->exec($query);
}


// Apply all migrations
$files = glob(MIGRATION_PATH . '*.sql');
foreach ($files as $file) {
    runMigration($pdo, $file, 'up');
}

echo "Migrations applied successfully.";
