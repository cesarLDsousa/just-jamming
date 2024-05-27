<?php

require __DIR__ . '/../vendor/autoload.php';

$databaseFile = "my_database.db";

try {
    if (file_exists($databaseFile)) {
        unlink($databaseFile);
        echo "Existing database file deleted.\n";
    }

    $db = new SQLite3('my_database.db');
} catch (Exception $e) {
    echo "Unable to connect to the database: " . $e->getMessage();
    exit();
}

// Create a table
$tableCreationQuery = "
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL
);
";

if (!$db->exec($tableCreationQuery)) {
    echo "Failed to create table 'users': " . $db->lastErrorMsg();
}

$insertQuery = "
INSERT INTO users (name, email) 
VALUES ('John Doe', 'john.doe@example.com');
";

if (!$db->exec($insertQuery)) {
    echo "Failed to insert data: " . $db->lastErrorMsg();
}

$users = $db->query("SELECT * FROM users");

while ($row = $users->fetchArray(SQLITE3_ASSOC)) {
    var_dump(json_encode($row, JSON_PRETTY_PRINT));
}

$db->close();

