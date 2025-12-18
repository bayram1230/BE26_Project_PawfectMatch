<?php
session_start();

require_once __DIR__ . "/../functions/user_restriction.php";
require_once __DIR__ . "/../../components/db_connect.php";

/* ---------------------------------
   Admin OR Shelter protection
---------------------------------- */
requireAdminOrShelter(); // Stelle sicher, dass du diese Funktion definiert hast

/* ---------------------------------
   Check ID (POST!)
---------------------------------- */
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid ID.");
}

$id = intval($_POST['id']);

/* ---------------------------------
   Get ImageUrl from DB
---------------------------------- */
$sql = "SELECT ImageUrl FROM animal WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Animal not found.");
}

/* ---------------------------------
   Delete local image file
---------------------------------- */
$image = $row['ImageUrl'];
if (!empty($image) && strpos($image, 'http') !== 0 && $image !== 'default-animals.png') {
    $filePath = __DIR__ . "/../../img/" . $image;
    if (file_exists($filePath)) {
        unlink($filePath);
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
   Redirect back to pet listings
---------------------------------- */
header("Location: /php/shelter/pets.php?deleted=1");
exit;
