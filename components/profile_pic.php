<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/db_connect.php";

$profilePic = "default-users.png";

if (isset($_SESSION["user"])) {
    $username = $_SESSION["user"];

    $sql = "SELECT Img FROM users WHERE Username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row["Img"])) {
            $profilePic = $row["Img"];
        }
    }
}
