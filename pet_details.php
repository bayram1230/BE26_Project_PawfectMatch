<?php
session_start();

require_once __DIR__ . "/components/db_connect.php";
require_once __DIR__ . "/php/functions/get_profile.php";
require_once __DIR__ . "/php/functions/user_restriction.php";

requireUser(); // nur USER darf rein

/* ID prüfen */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<h3>No valid animal selected.</h3>");
}

$id = (int) $_GET['id'];

/* DB */
$sql = "SELECT * FROM animal WHERE ID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
    die("<h3>Animal not found.</h3>");
}

$row = mysqli_fetch_assoc($result);

/* IMAGE handling (WICHTIG) */
if (!empty($row['ImageUrl'])) {
    $imgPath = (str_starts_with($row['ImageUrl'], 'http'))
        ? $row['ImageUrl']
        : "img/" . $row['ImageUrl'];
} else {
    $imgPath = "img/default-animals.png";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($row['Name']) ?> – Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="body-pic">

<?php require_once "components/navbar.php"; ?>
<?php require_once __DIR__ . "/php/user/user_menu.php"; ?>
<?php require_once __DIR__ . "/php/user/btn.php"; ?>

<div class="container details-container my-5">

    <a href="pets.php" class="details-back-button mb-4 d-inline-block">
        ← Back to Search
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card paw-card paw-card--details">
                <div class="paw-card-inner">
                    <div class="details-content">

                        <!-- LEFT -->
                        <div class="details-left">
                            <h2 class="details-name">
                                <?= htmlspecialchars($row['Name']) ?>
                            </h2>

                            <img
                                src="<?= htmlspecialchars($imgPath) ?>"
                                class="details-card-img"
                                alt="<?= htmlspecialchars($row['Name']) ?>"
                                onerror="this.src='img/default-animals.png'"
                            >

                            <a href="php/user/apply.php?id=<?= $row['ID'] ?>"
                               class="details-inline-btn mt-3">
                                🐾 Take Me Home 🐾
                            </a>
                        </div>

                        <!-- RIGHT -->
                        <div class="details-right">

                            <h5>Description</h5>
                            <p><?= nl2br(htmlspecialchars($row['Description'])) ?></p>

                            <h5 class="mt-4">Characteristics</h5>

                            <table class="details-table">
                                <tr><th>Type:</th><td><?= htmlspecialchars($row['Type']) ?></td></tr>
                                <tr><th>Breed:</th><td><?= htmlspecialchars($row['Breed']) ?></td></tr>
                                <tr><th>Sex:</th><td><?= htmlspecialchars($row['Sex']) ?></td></tr>
                                <tr><th>Age:</th><td><?= htmlspecialchars($row['Age']) ?></td></tr>
                                <tr><th>Color:</th><td><?= htmlspecialchars($row['Color']) ?></td></tr>
                                <tr><th>Size:</th><td><?= htmlspecialchars($row['Size']) ?></td></tr>
                            </table>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
