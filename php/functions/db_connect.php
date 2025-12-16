<?php
// Database connection settings
$hostname = "localhost";   // or 127.0.0.1
$username = "root";        // your MySQL username
$password = "";            // your MySQL password (often empty for local dev)
$database = "pawfectmatch"; // the name of your database

// Create connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
