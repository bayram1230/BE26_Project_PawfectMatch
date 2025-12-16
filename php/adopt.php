<?php
require_once __DIR__ . "/functions/db_connect.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $petId = intval($_GET['id']);
    // Use lowercase ENUM values: 'available','fostered','adopted'
    $sql = "UPDATE pets SET status='adopted' WHERE id=$petId AND status='fostered'";
    if (mysqli_query($conn, $sql)) {
        header("Location: details.php?id=$petId&adopted=1");
        exit;
    } else {
        echo "Error adopting pet.";
    }
} else {
    echo "Invalid pet ID.";
}
?>
