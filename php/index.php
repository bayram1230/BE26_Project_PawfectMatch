<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

$sql = "SELECT * FROM pets WHERE status='available'";
$result = mysqli_query($conn, $sql);
if ($result === false) {
    $errorMsg = "Database query failed: " . mysqli_error($conn);
}

$daySql = "SELECT * FROM pets ORDER BY RAND() LIMIT 1";
$dayResult = mysqli_query($conn, $daySql);
$petOfDay = $dayResult && mysqli_num_rows($dayResult) > 0 ? mysqli_fetch_assoc($dayResult) : null;

$weekSql = "SELECT * FROM pets WHERE status='available' ORDER BY RAND() LIMIT 1";
$weekResult = mysqli_query($conn, $weekSql);
$petOfWeek = $weekResult && mysqli_num_rows($weekResult) > 0 ? mysqli_fetch_assoc($weekResult) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PawfectMatch Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + FontAwesome + Your CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="../css/style.css" rel="stylesheet"><!-- ✅ corrected path -->
</head>
<body class="body-pic">
    <div class="container index-container mt-4">
        <!-- Highlights Section -->
        <div class="row mb-5">
            <div class="col-md-6">
                <?php if ($petOfDay): ?>
                    <?php $dayPic = !empty($petOfDay['picture']) ? $petOfDay['picture'] : "pet.jpg"; ?>
                    <div class="card paw-card text-center">
                        <h4 class="card-header">🐶 Pet of the Day</h4>
                        <img src="../img/<?= htmlspecialchars($dayPic) ?>" 
                             class="paw-card-img img-fluid rounded mx-auto d-block mb-3" 
                             alt="<?= htmlspecialchars($petOfDay['name']) ?>">
                        <div class="card-body">
                            <h5 class="paw-card-title"><?= htmlspecialchars($petOfDay['name']) ?></h5>
                            <p class="paw-card-meta">
                                <?= !empty($petOfDay['short_description']) ? htmlspecialchars($petOfDay['short_description']) : 'No description available.' ?>
                            </p>
                            <a href="details.php?id=<?= intval($petOfDay['id']) ?>" class="btn paw-card-btn">View Details</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <?php if ($petOfWeek): ?>
                    <?php $weekPic = !empty($petOfWeek['picture']) ? $petOfWeek['picture'] : "pet.jpg"; ?>
                    <div class="card paw-card text-center">
                        <h4 class="card-header">🐾 Pet of the Week</h4>
                        <img src="../img/<?= htmlspecialchars($weekPic) ?>" 
                             class="paw-card-img img-fluid rounded mx-auto d-block mb-3" 
                             alt="<?= htmlspecialchars($petOfWeek['name']) ?>">
                        <div class="card-body">
                            <h5 class="paw-card-title"><?= htmlspecialchars($petOfWeek['name']) ?></h5>
                            <p class="paw-card-meta">
                                <?= !empty($petOfWeek['short_description']) ? htmlspecialchars($petOfWeek['short_description']) : 'No description available.' ?>
                            </p>
                            <a href="details.php?id=<?= intval($petOfWeek['id']) ?>" class="btn paw-card-btn">View Details</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="text-center mb-5">
            <a href="fostered_pets.php" class="btn btn-warning me-2">View Fostered Pets</a>
            <a href="adopted_pets.php" class="btn btn-info">View Adopted Pets</a>
        </div>

        <!-- Available Pets Section -->
        <h2 class="paw-card-h1 mt-4">Available Pets</h2>
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
                                            $picturePath = "../img/" . htmlspecialchars($picture);
                                        ?>
                                            <div class="col-md-4 mb-4">
                                                <div class="card paw-card text-center h-100">
                                                    <h5 class="paw-card-title card-header"><?= htmlspecialchars($pet['name']) ?></h5>
                                                    <img src="<?= $picturePath ?>" 
                                                         class="paw-card-img img-fluid rounded mx-auto d-block mb-3" 
                                                         alt="<?= htmlspecialchars($pet['name']) ?>">
                                                    <div class="card-body">
                                                        <p class="paw-card-meta">
                                                            <?= !empty($pet['short_description']) ? htmlspecialchars($pet['short_description']) : 'No description available.' ?>
                                                        </p>
                                                        <a href="details.php?id=<?= intval($pet['id']) ?>" class="btn paw-card-btn">View Details</a>
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

    <!-- Footer -->
    <?php include __DIR__ . '/../components/footer.php'; ?><!-- ✅ correct relative path -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
