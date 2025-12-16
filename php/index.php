<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

// IMPORTANT: status values in the DB are lowercase ('available','fostered','adopted')
$sql = "SELECT * FROM pets WHERE status='available'";
$result = mysqli_query($conn, $sql);
if ($result === false) {
    $errorMsg = "Database query failed: " . mysqli_error($conn);
}

// Pet of the Day (any random pet)
$daySql = "SELECT * FROM pets ORDER BY RAND() LIMIT 1";
$dayResult = mysqli_query($conn, $daySql);
$petOfDay = $dayResult && mysqli_num_rows($dayResult) > 0 ? mysqli_fetch_assoc($dayResult) : null;

// Pet of the Week (random available pet)
$weekSql = "SELECT * FROM pets WHERE status='available' ORDER BY RAND() LIMIT 1";
$weekResult = mysqli_query($conn, $weekSql);
$petOfWeek = $weekResult && mysqli_num_rows($weekResult) > 0 ? mysqli_fetch_assoc($weekResult) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PawfectMatch Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Carousel arrow positioning (does not affect card styles) */
        .carousel-control-prev,
        .carousel-control-next { width: 5%; }
        .carousel-control-prev { left: -60px; }
        .carousel-control-next { right: -60px; }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(0%) brightness(0%) contrast(100%);
        }

        /* Scoped styles: ONLY for Available Pets cards */
        .available-pets .ap-card-img {
            height: 250px;
            object-fit: cover;
        }
        .available-pets .card { /* match look without touching day/week cards */
            border-radius: .5rem;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        }
        .available-pets .ap-card-img:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="container mt-4">
        <!-- Highlights Section (UNCHANGED) -->
        <div class="row mb-5">
            <div class="col-md-6">
                <?php if ($petOfDay): ?>
                    <?php $dayPic = !empty($petOfDay['picture']) ? $petOfDay['picture'] : "pet.jpg"; ?>
                    <div class="card shadow text-center">
                        <h4 class="card-header">🐶 Pet of the Day</h4>
                        <img src="img/<?= htmlspecialchars($dayPic) ?>" 
                             class="img-fluid rounded mx-auto d-block mb-3" 
                             alt="<?= htmlspecialchars($petOfDay['name']) ?>">
                        <div class="card-body">
                            <h5><?= htmlspecialchars($petOfDay['name']) ?></h5>
                            <p><?= !empty($petOfDay['short_description']) ? htmlspecialchars($petOfDay['short_description']) : 'No description available.' ?></p>
                            <a href="details.php?id=<?= intval($petOfDay['id']) ?>" class="btn btn-success">View Details</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <?php if ($petOfWeek): ?>
                    <?php $weekPic = !empty($petOfWeek['picture']) ? $petOfWeek['picture'] : "pet.jpg"; ?>
                    <div class="card shadow text-center">
                        <h4 class="card-header">🐾 Pet of the Week</h4>
                        <img src="img/<?= htmlspecialchars($weekPic) ?>" 
                             class="img-fluid rounded mx-auto d-block mb-3" 
                             alt="<?= htmlspecialchars($petOfWeek['name']) ?>">
                        <div class="card-body">
                            <h5><?= htmlspecialchars($petOfWeek['name']) ?></h5>
                            <p><?= !empty($petOfWeek['short_description']) ? htmlspecialchars($petOfWeek['short_description']) : 'No description available.' ?></p>
                            <a href="details.php?id=<?= intval($petOfWeek['id']) ?>" class="btn btn-success">View Details</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Links (UNCHANGED) -->
        <div class="text-center mb-5">
            <a href="fostered_pets.php" class="btn btn-warning me-2">View Fostered Pets</a>
            <a href="adopted_pets.php" class="btn btn-info">View Adopted Pets</a>
        </div>

        <!-- Available Pets Section (RE-STYLED TO MATCH WEEK, SCOPED) -->
        <h2 class="mt-4">Available Pets</h2>
        <div class="available-pets">
            <?php
            if (isset($errorMsg)) {
                echo '<div class="alert alert-danger">' . htmlspecialchars($errorMsg) . '</div>';
            } elseif ($result && mysqli_num_rows($result) > 0) {
                ?>
                <div id="availablePetsCarousel" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php 
                        $first = true;
                        $count = 0;
                        $rowItems = [];
                        $total = mysqli_num_rows($result);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $rowItems[] = $row;
                            $count++;
                            if ($count % 3 === 0 || $count === $total) {
                                ?>
                                <div class="carousel-item <?= $first ? 'active' : '' ?>">
                                    <div class="row justify-content-center">
                                        <?php foreach ($rowItems as $pet): 
                                            $picture = !empty($pet['picture']) ? $pet['picture'] : "pet.jpg";
                                            $picturePath = "img/" . htmlspecialchars($picture);
                                        ?>
                                            <div class="col-md-4 mb-4">
                                                <!-- Match Pet of the Week look, scoped classes so we don't affect good cards -->
                                                <div class="card text-center h-100">
                                                    <h5 class="card-header"><?= htmlspecialchars($pet['name']) ?></h5>
                                                    <img src="<?= $picturePath ?>" 
                                                         class="ap-card-img img-fluid rounded mx-auto d-block mb-3" 
                                                         alt="<?= htmlspecialchars($pet['name']) ?>">
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            <?= !empty($pet['short_description']) ? htmlspecialchars($pet['short_description']) : 'No description available.' ?>
                                                        </p>
                                                        <a href="details.php?id=<?= intval($pet['id']) ?>" class="btn btn-success">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php
                                $rowItems = [];
                                $first = false;
                            }
                        }
                        ?>
                    </div>
                    <!-- Carousel controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#availablePetsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#availablePetsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <?php
            } else {
                echo '<p>No pets available at the moment.</p>';
            }
            ?>
        </div>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
