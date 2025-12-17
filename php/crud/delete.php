<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . "/../../components/db_connect.php";

/* ---------------------------------
   Login check
---------------------------------- */
if (!isset($_SESSION['username'], $_SESSION['role'], $_SESSION['user_id'])) {
    die("Not logged in.");
}

$userId = (int) $_SESSION['user_id'];
$role   = $_SESSION['role'];

/* ---------------------------------
   Only admin or shelter allowed
---------------------------------- */
if (!in_array($role, ['admin', 'shelter'], true)) {
    die("Permission denied.");
}

/* ---------------------------------
   Validate ID
---------------------------------- */
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid ID.");
}

$animalId = (int) $_POST['id'];

/* ---------------------------------
   Get animal (ImageUrl + owner)
---------------------------------- */
$sql = "SELECT ImageUrl, shelter_id FROM animal WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $animalId);
$stmt->execute();

$result = $stmt->get_result();
$animal = $result->fetch_assoc();

if (!$animal) {
    die("Animal not found.");
}

/* ---------------------------------
   Shelter: only own animals
---------------------------------- */
if ($role === 'shelter' && (int)$animal['shelter_id'] !== $userId) {
    die("You are not allowed to delete this animal.");
}

/* ---------------------------------
   Delete image (if local & not default)
---------------------------------- */
if (
    !empty($animal['ImageUrl']) &&
    $animal['ImageUrl'] !== 'default-animals.png' &&
    strpos($animal['ImageUrl'], 'http') !== 0
) {
    $filePath = __DIR__ . "/../../img/" . $animal['ImageUrl'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

/* ---------------------------------
   Delete animal
---------------------------------- */
$deleteSql = "DELETE FROM animal WHERE id = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $animalId);
$stmt->execute();

/* ---------------------------------
   Redirect
---------------------------------- */
header("Location: http://localhost:3000/index.php?deleted=1");
exit;
