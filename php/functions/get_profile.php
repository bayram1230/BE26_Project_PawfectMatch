<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../components/db_connect.php';

/**
 * Returns avatar filename of logged-in user
 */
function getProfilePicture($conn) {

<<<<<<< HEAD
    // Get ID of admin or user
    $id = $_SESSION['admin'] ?? $_SESSION['user'] ?? null;

    // Guest → Default avatar
    if (!$id) return "default-users.png";

    // DB 
    $sql = "SELECT Img FROM users WHERE Username = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // If User has own img → take it
    if (!empty($row['Img'])) {
        return $row['Img'];
=======
    // Not logged in → default avatar
    if (!isset($_SESSION['username'])) {
        return "default-users.png";
    }

    $username = $_SESSION['username'];

    // IMPORTANT: Username + Img EXACTLY like DB column names
    $sql = "SELECT Img FROM users WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return "default-users.png";
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return (!empty($row['Img']))
            ? $row['Img']
            : "default-users.png";
>>>>>>> f7d6e40fcb13d1a3bb2b37f39b791d4fe18f0941
    }

    return "default-users.png";
}

/**
 * Base URL of the project (IMPORTANT!)
 */
define("BASE_URL", "http://localhost:8000/");



/**
 * Returns dashboard link based on role
 */
function getProfileLink() {

    // Guest → login
    if (!isset($_SESSION['username'], $_SESSION['role'])) {
        return BASE_URL . "php/login/login.php";
    }

    return match ($_SESSION['role']) {
        'admin'   => BASE_URL . "php/admin/admin_dashboard.php",
        'shelter' => BASE_URL . "php/shelter/shelter_dashboard.php",
        default   => BASE_URL . "php/user/user_dashboard.php",
    };
}
