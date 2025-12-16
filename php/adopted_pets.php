<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

// IMPORTANT: status values in the DB are lowercase ('available','fostered','adopted')
$sql = "SELECT * FROM pets WHERE status='adopted'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Adopted Pets</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar OUTSIDE container -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2 class="mt-4">🏡 Adopted Pets</h2>
    <p class="lead">These pets have already been adopted and are enjoying their new homes.</p>

    <div class="row">
      <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($pet = mysqli_fetch_assoc($result)): ?>
          <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
              <img src="img/<?= htmlspecialchars(!empty($pet['picture']) ? $pet['picture'] : 'pet.jpg') ?>" 
                   class="card-img-top img-fluid rounded mx-auto d-block" 
                   alt="<?= htmlspecialchars($pet['name']) ?>">
              <div class="card-body text-center">
                <h5 class="card-title"><?= htmlspecialchars($pet['name']) ?></h5>
                <p class="card-text">
                  <?= !empty($pet['short_description']) ? htmlspecialchars($pet['short_description']) : 'No description available.' ?>
                </p>
                <span class="badge bg-secondary">Adopted</span>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="alert alert-info">No pets have been adopted yet.</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Footer OUTSIDE container -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle for dropdowns -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
