<?php
// Always include DB connection and profile functions first
require_once __DIR__ . "/../functions/db_connect.php";
require_once __DIR__ . "/../functions/get_profile.php";
// require_once __DIR__ . "/../functions/user_restriction.php"; // uncomment if you add restrictions

// Check if id exists
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Ungültige ID");
}

$id = intval($_GET['id']);

// Get pet data from DB
$sql = "SELECT picture FROM pets WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Eintrag existiert nicht.");
}

// Delete image from filesystem, if not the default pet image
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Navbar include -->
        <?php include __DIR__ . '/navbar.php'; ?>
        <!-- Navbar end -->

        <h3 class="mt-5">Deleting pet...</h3>

        <!-- Footer include -->
        <?php include __DIR__ . '/footer.php'; ?>
        <!-- Footer End -->
    </div>
</body>
</html>
