<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

// Pick a random available pet for Pet of the Week
$sql = "SELECT * FROM pets WHERE status='available' ORDER BY RAND() LIMIT 1";
$result = mysqli_query($conn, $sql);

$pet = null;
if ($result && mysqli_num_rows($result) > 0) {
    $pet = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pet of the Week</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Scoped styles: ONLY for Pet of the Week card */
    .pet-week .pw-card-img {
      height: 250px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .pet-week .pw-card-img:hover {
      transform: scale(1.05);
    }
    .pet-week .card {
      border-radius: .5rem;
      box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
    }
    .pet-week .card-header,
    .pet-week .card-body {
      text-align: center; /* Center title and text */
    }
  </style>
</head>
<body>
  <!-- Navbar OUTSIDE container -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5 pet-week">
    <h2 class="mt-4 text-center">🐾 Pet of the Week</h2>
    <p class="lead text-center">Each week we highlight one special pet looking for a forever home.</p>

    <?php if ($pet): ?>
      <div class="card mb-4">
        <h4 class="card-header"><?= htmlspecialchars($pet['name']) ?></h4>
        <img src="img/<?= htmlspecialchars(!empty($pet['picture']) ? $pet['picture'] : 'pet.jpg') ?>" 
             alt="<?= htmlspecialchars($pet['name']) ?>" 
             class="pw-card-img img-fluid rounded mx-auto d-block mb-3">
        <div class="card-body">
          <p class="card-text">
            <?= !empty($pet['short_description']) ? htmlspecialchars($pet['short_description']) : 'No description available.' ?><br>
            <strong>Breed:</strong> <?= !empty($pet['breed']) ? htmlspecialchars($pet['breed']) : 'Unknown' ?><br>
            <strong>Age:</strong> <?= htmlspecialchars($pet['age']) ?> years<br>
            <strong>Location:</strong> <?= !empty($pet['location']) ? htmlspecialchars($pet['location']) : 'Not specified' ?>
          </p>
          <a href="details.php?id=<?= intval($pet['id']) ?>" class="btn btn-success">Learn More</a>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">No Pet of the Week available right now.</div>
    <?php endif; ?>
  </div>

  <!-- Footer OUTSIDE container -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle for dropdowns -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
