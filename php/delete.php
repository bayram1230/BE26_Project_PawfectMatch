<?php
// require_once "../functions/user_restriction.php";
// require_once "../functions/db_connect.php";
// require_once "../functions/get_profile.php";

// Check if id exists
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Ungültige ID");
}

$id = intval($_GET['id']);

// get pets data from DB
$sql = "SELECT picture FROM pets WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Eintrag existiert nicht.");
}

// Delete img from DB, if not standard pet img
if (!empty($row['picture']) && $row['picture'] !== 'pet.jpg') {
    $filePath = __DIR__ . "/img/" . $row['picture'];

    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Delete data from DB
$deleteSql = "DELETE FROM pets WHERE id = ?";
$stmt2 = $conn->prepare($deleteSql);
$stmt2->bind_param("i", $id);
$stmt2->execute();

// Redirect
header("Location: ../../index.php?deleted=1");
exit;
?>
