<?php
require_once __DIR__ . "/functions/db_connect.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $petId = intval($_GET['id']);
    // Use lowercase ENUM values: 'available','fostered','adopted'
    $sql = "UPDATE pets SET status='fostered' WHERE id=$petId AND status='available'";
    if (mysqli_query($conn, $sql)) {
        header("Location: details.php?id=$petId&fostered=1");
        exit;
    } else {
        echo "Error fostering pet.";
    }
} else {
    echo "Invalid pet ID.";
}
?>
