<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "db_connect.php";

/* Returns avatar of logged-in user (admin or user) */
function getProfilePicture($conn) {

    // Get ID of admin or user
    $id = $_SESSION['admin'] ?? $_SESSION['user'] ?? null;

    // Guest → Default avatar
    if (!$id) return "default-users.png";

    // DB 
    $sql = "SELECT Img FROM users WHERE ID = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // If User has own img → take it
    if (!empty($row['Img'])) {
        return $row['Img'];
    }

    // If no own img → Default avatar
    return "default-users.png";
}

// Base URL
define("BASE_URL", "http://localhost:8000/");

// Checks Login-Status -> redirects to the right profile
function getProfileLink() {
    if (isset($_SESSION['admin'])) 
        return BASE_URL . "php/crud/dashboard.php";

    if (isset($_SESSION['user']))  
        return BASE_URL . "php/register-login/userprofile.php";

    // Guests → Login page
    return BASE_URL . "php/register-login/login.php";
}

