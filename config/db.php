<?php
$host = "localhost";
$dbname = "senpaistore_db";
$username = "root";
$password = "";

try {
    // Create PDO connection and store in $conn
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
