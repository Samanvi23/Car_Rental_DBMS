<?php
// config.php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'carrental');
define('DB_USER', 'root');  // Default XAMPP username
define('DB_PASS', 'samanviii');      // Default XAMPP password (blank)

// Create database connection
try {
    $dbh = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
        
?>