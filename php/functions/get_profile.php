<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../components/db_connect.php';
/**
 * Returns avatar filename of logged-in user
 */
function getProfilePicture($conn)
{
    // 🔐 Login-Status eindeutig
    if (!isset($_SESSION['user_id'])) {
        return "default-users.png";
    }

    if (!isset($_SESSION['username'])) {
        return "default-users.png";
    }

    $username = $_SESSION['username'];

    $sql = "SELECT Img FROM users WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return "default-users.png";
    }

    // ✅ HIER war der White-Screen-Fehler
    mysqli_stmt_bind_param($stmt, "s", $username);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        if (!empty($row['Img'])) {
            return $row['Img'];
        }
    }

    // 👇 Fallback IMMER
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