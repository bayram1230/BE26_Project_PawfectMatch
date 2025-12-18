<?php
session_start();
error_reporting(E_ALL);


require_once "../../components/db_connect.php";
require_once "../../components/navbar.php";
require_once "../functions/get_profile.php";
require_once "../functions/user_restriction.php";

requireShelter(); // Nur Shelter darf rein

/* Profile picture */
$profilePic = getProfilePicture($conn);

/* Fetch all pets */
$pets = $conn->query("SELECT * FROM animal ORDER BY ID DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Listings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/style.css" rel="stylesheet">
</head>
<body class="body-pic">

<div class="container mt-5">

    <!-- HEADER + ADD BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="paw-card-h1">Pet Listings</h1>
        <a href="../crud/create.php" class="btn add-new-pet-btn">
            ➕ Add New Pet
        </a>
    </div>

    <!-- PET CARDS -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        <?php while($pet = $pets->fetch_assoc()): ?>
            <?php
                $id   = (int)$pet['ID'];
                $name = htmlspecialchars($pet['Name'] ?? 'Unnamed');
                $type = htmlspecialchars($pet['Type'] ?? '');
                $breed = htmlspecialchars($pet['Breed'] ?? '');
                $age  = htmlspecialchars($pet['Age'] ?? '');
                $sex  = htmlspecialchars($pet['Sex'] ?? '');
                $desc = htmlspecialchars(substr($pet['Description'] ?? '', 0, 90));
                $req  = htmlspecialchars(substr($pet['adoption_requirements'] ?? '', 0, 80) ?: 'No requirements specified');
                $img  = htmlspecialchars($pet['ImageUrl'] ?? 'default-animals.png');
            ?>

            <div class="col">
                <div class="card h-100 paw-card">
                    <img src="<?= $img ?>" class="paw-card-img-fixed" alt="<?= $name ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $name ?> (<?= $type ?>)</h5>
                        <p class="mb-1"><strong>Breed:</strong> <?= $breed ?></p>
                        <p class="mb-1"><strong>Age:</strong> <?= $age ?> | <strong>Sex:</strong> <?= $sex ?></p>
                        <p class="mt-2"><?= $desc ?>...</p>
                        <p>
                            <strong>Requirements:</strong><br>
                            <?= $req ?>
                        </p>

                        <!-- ACTION BUTTONS -->
                        <div class="mt-auto d-flex gap-2">
                            <a href="../crud/details.php?id=<?= $id ?>" class="btn btn-info btn-sm w-100">
                                Details
                            </a>
                            <a href="../crud/update.php?id=<?= $id ?>" class="btn btn-warning btn-sm w-100">
                                Update
                            </a>
                            <form method="POST" action="../crud/delete.php" class="w-100" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        <?php endwhile; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
