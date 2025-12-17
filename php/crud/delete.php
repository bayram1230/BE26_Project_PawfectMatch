<?php
session_start();

require_once __DIR__ . "/../functions/user_restriction.php";
require_once __DIR__ . "/../../components/db_connect.php";

/* ---------------------------------
   Admin-only protection
---------------------------------- */
requireAdmin();

/* ---------------------------------
   Check ID (POST!)
---------------------------------- */
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid ID.");
}

$id = intval($_POST['id']);

/* ---------------------------------
   Get image from DB
---------------------------------- */
$sql = "SELECT img FROM animal WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Animal not found.");
}

/* ---------------------------------
   Delete image (only local files)
---------------------------------- */
if (!empty($row['img'])) {

    // delete ONLY if NOT URL and NOT default image
    if (
        strpos($row['img'], 'http') !== 0 &&
        $row['img'] !== 'default-animals.png'
    ) {
        $filePath = __DIR__ . "/../../img/" . $row['img'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}

/* ---------------------------------
   Delete DB entry
---------------------------------- */
$deleteSql = "DELETE FROM animal WHERE ID = ?";
$stmt2 = $conn->prepare($deleteSql);
$stmt2->bind_param("i", $id);
$stmt2->execute();

/* ---------------------------------
   Redirect
---------------------------------- */
header("Location: /index.php?deleted=1");
exit;
