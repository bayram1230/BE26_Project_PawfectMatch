<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../components/db_connect.php';

/**
 * Returns avatar filename of logged-in user
 */
function getProfilePicture($conn) {

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
