<?php

require_once __DIR__ . "/../../components/db_connect.php";
require_once "../functions/user_restriction.php";
requireAdmin();

/* ---------------------------------
   Admin check
---------------------------------- */
if (
    !isset($_SESSION['user_id'], $_SESSION['role']) ||
    $_SESSION['role'] !== 'admin'
) {
    die("Access denied.");
}

/* ---------------------------------
   Validate user ID
---------------------------------- */
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid user ID.");
}

$deleteUserId = (int) $_POST['id'];

/* ---------------------------------
   Prevent self-delete
---------------------------------- */
if ($deleteUserId === (int) $_SESSION['user_id']) {
    die("You cannot delete your own account.");
}

/* ---------------------------------
   Get user (for image)
---------------------------------- */
$sql = "SELECT Img FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $deleteUserId);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

/* ---------------------------------
   Delete profile image (optional)
---------------------------------- */
if (
    !empty($user['Img']) &&
    $user['Img'] !== 'default-user.png' &&
    strpos($user['Img'], 'http') !== 0
) {
    $filePath = __DIR__ . "/../../img/" . $user['Img'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

/* ---------------------------------
   Delete user
   (animals deleted automatically via FK)
---------------------------------- */
$deleteSql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $deleteUserId);
$stmt->execute();

/* ---------------------------------
   Redirect
---------------------------------- */
header("Location: admin_users.php?deleted=1");
exit;
