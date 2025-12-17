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
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
// Projekt-Ordner automatisch erkennen
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$projectRoot = explode('/php/', $scriptDir)[0];
define("BASE_URL", $protocol . "://" . $host . $projectRoot . "/");
/**
 *  Redirect link based on role
 */
function getProfileLink()
{
    if (!isset($_SESSION['username'], $_SESSION['role'])) {
        return BASE_URL . "php/login/login.php";
    }
    if ($_SESSION['role'] === 'admin') {
        return BASE_URL . "php/admin/admin_dashboard.php";
    }
    if ($_SESSION['role'] === 'shelter') {
        return BASE_URL . "php/shelter/shelter_dashboard.php";
    }
    return BASE_URL . "php/user/user_dashboard.php";
}