<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Adoption Stories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- Navbar OUTSIDE container -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2 class="mt-4">🐾 Adoption Stories</h2>
    <p class="lead">Read inspiring stories from families who found their perfect match through PawfectMatch.</p>

    <div class="row mt-4">
      <div class="col-md-4 mb-4">
        <div class="card shadow h-100 text-center">
          <img src="img/pet.jpg" alt="Max the Labrador" class="img-fluid rounded mx-auto d-block mb-3">
          <div class="card-body">
            <h4 class="card-title">Max the Labrador</h4>
            <p class="card-text">Max was rescued from a shelter and is now living happily with his new family in Vienna. His playful energy has brought joy to everyone at home.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card shadow h-100 text-center">
          <img src="img/pet.jpg" alt="Luna the Cat" class="img-fluid rounded mx-auto d-block mb-3">
          <div class="card-body">
            <h4 class="card-title">Luna the Cat</h4>
            <p class="card-text">Luna was shy at first, but thanks to patient adopters she has blossomed into a loving companion. Her story shows the power of giving pets a second chance.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card shadow h-100 text-center">
          <img src="img/pet.jpg" alt="Rocky the Senior Dog" class="img-fluid rounded mx-auto d-block mb-3">
          <div class="card-body">
            <h4 class="card-title">Rocky the Senior Dog</h4>
            <p class="card-text">Rocky found a foster‑to‑adopt family who gave him comfort in his golden years. His journey proves that senior pets make wonderful companions too.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer OUTSIDE container -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle for dropdowns -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
