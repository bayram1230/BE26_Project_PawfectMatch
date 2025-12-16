<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

// First, get Pet of the Week so we know its ID
$sqlWeek = "SELECT * FROM pets WHERE status='Available' ORDER BY RAND() LIMIT 1";
$resultWeek = mysqli_query($conn, $sqlWeek);
$petWeek = null;
if ($resultWeek && mysqli_num_rows($resultWeek) > 0) {
    $petWeek = mysqli_fetch_assoc($resultWeek);
}

// Then, get Pet of the Day excluding Pet of the Week
$excludeId = $petWeek ? intval($petWeek['id']) : 0;
$sqlDay = "SELECT * FROM pets WHERE status='Available' AND id != $excludeId ORDER BY RAND() LIMIT 1";
$resultDay = mysqli_query($conn, $sqlDay);
$petDay = null;
if ($resultDay && mysqli_num_rows($resultDay) > 0) {
    $petDay = mysqli_fetch_assoc($resultDay);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pet of the Day</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <?php include __DIR__ . '/navbar.php'; ?>

    <h2 class="mt-4">🌟 Pet of the Day</h2>
    <p class="lead">Every day we showcase a different pet waiting for a loving home.</p>

    <?php if ($petDay): ?>
      <div class="card mb-4 shadow text-center">
        <img src="../img/<?= htmlspecialchars($petDay['picture']) ?>" 
             alt="<?= htmlspecialchars($petDay['name']) ?>" 
             class="img-fluid mx-auto d-block rounded" 
             style="max-width: 300px; height: auto;">
        <div class="card-body">
          <h4 class="card-title"><?= htmlspecialchars($petDay['name']) ?></h4>
          <p class="card-text">
            <?= htmlspecialchars($petDay['short_description']) ?><br>
            <strong>Breed:</strong> <?= htmlspecialchars($petDay['breed']) ?><br>
            <strong>Age:</strong> <?= htmlspecialchars($petDay['age']) ?> years<br>
            <strong>Location:</strong> <?= htmlspecialchars($petDay['location']) ?>
          </p>
          <a href="details.php?id=<?= intval($petDay['id']) ?>" class="btn btn-success">Learn More</a>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-warning">No Pet of the Day available right now.</div>
    <?php endif; ?>

    <?php include __DIR__ . '/footer.php'; ?>
  </div>
</body>
</html>
