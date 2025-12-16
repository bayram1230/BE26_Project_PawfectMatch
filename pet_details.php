<?php
session_start();
require_once "components/db_connect.php";
require_once "php/functions/get_profile.php";
require_once "php/functions/user_restriction.php";

requireUser();




if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: php/login/login.php?restricted=true");
    exit;
}


if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("<h3>No animal selected.</h3>");
}

$id = (int) $_GET["id"];


$sql = "SELECT * FROM animal WHERE ID = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("<h3>Animal not found.</h3>");
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
include_once "navbar-user.php";
?> 

<div class="container details-container my-5">
    <h1 class="custom-card-h1 text-center">Pet Details</h1>

    <div class="card details-card text-center">
        <div class="card-body details-card-body">

            <img src="img/<?= htmlspecialchars($row['ImageUrl']) ?>"
                 class="custom-card-img"
                 alt="<?= htmlspecialchars($row['Name']) ?>">

            <div class="details-right mt-3">
                <h2 class="card-title"><?= htmlspecialchars($row['Name']) ?></h2>

                <div class="description-wrapper">
                    <p class="card-text"><?= nl2br(htmlspecialchars($row['Description'])) ?></p>
                </div>

                <table class="details-table mx-auto my-3 text-start">
                    <tr><th>Type:</th><td><?= $row['Type'] ?></td></tr>
                    <tr><th>Breed:</th><td><?= $row['Breed'] ?></td></tr>
                    <tr><th>Sex:</th><td><?= $row['Sex'] ?></td></tr>
                    <tr><th>Age:</th><td><?= $row['Age'] ?></td></tr>
                    <tr><th>Color:</th><td><?= $row['Color'] ?></td></tr>
                    <tr><th>Size:</th><td><?= $row['Size'] ?></td></tr>
                </table>

               
                <a href="php/user/apply.php?id=<?= $row['ID'] ?>" class="btn btn-success mt-3">
                    Take Me Home 🐾
                </a>
                <a href="pets.php" class="btn btn-success mt-3 ">
                    Back to Search
                     </a>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>