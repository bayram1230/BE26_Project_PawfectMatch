<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

$sql = "SELECT * FROM pets WHERE status='fostered'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fostered Pets</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Scoped styles: ONLY for Fostered Pets cards */
    .fostered-pets .fp-card-img {
      height: 250px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .fostered-pets .fp-card-img:hover {
      transform: scale(1.05);
    }
    .fostered-pets .card {
      border-radius: .5rem;
      box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
    }
  </style>
</head>
<body>
  <!-- Navbar OUTSIDE container -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5 fostered-pets">
    <h2 class="mt-4">🐕 Fostered Pets</h2>
    <p class="lead">These pets are currently in foster care, waiting for their forever homes.</p>

    <div class="row">
      <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($pet = mysqli_fetch_assoc($result)): 
          $picture = !empty($pet['picture']) ? $pet['picture'] : 'pet.jpg';
          $picturePath = 'img/' . htmlspecialchars($picture);
        ?>
          <div class="col-md-4 mb-4">
            <!-- Match Pet of the Week look, scoped so other pages remain unchanged -->
            <div class="card text-center h-100">
              <h5 class="card-header"><?= htmlspecialchars($pet['name']) ?></h5>
              <img src="<?= $picturePath ?>" 
                   class="fp-card-img img-fluid rounded mx-auto d-block mb-3" 
                   alt="<?= htmlspecialchars($pet['name']) ?>">
              <div class="card-body">
                <p class="card-text">
                  <?= !empty($pet['short_description']) ? htmlspecialchars($pet['short_description']) : 'No description available.' ?>
                </p>
                <a href="details.php?id=<?= intval($pet['id']) ?>" class="btn btn-success">View Details</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="alert alert-info">No pets are currently fostered.</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Footer OUTSIDE container -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle for dropdowns -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
