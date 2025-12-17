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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + FontAwesome + Shared CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link href="../css/style.css" rel="stylesheet">

  <style>
    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      /* ✅ no forced background-color, inherits your project’s footer styling */
      padding: 1rem 0;
    }
    body {
      margin-bottom: 100px; /* prevent overlap with sticky footer */
    }
  </style>
</head>
<body class="body-pic">
  <div class="container index-container mt-5">
    <!-- ✅ Professional heading + intro -->
    <h2 class="paw-card-h1 text-white text-center mb-3" 
        style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
      🏡 Adopted Pets
    </h2>
    <p class="lead text-white text-center mb-4" style="opacity: 0.9;">
      These pets have already been adopted and are enjoying their new homes.
    </p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($pet = mysqli_fetch_assoc($result)): 
          // Fallback: use DB picture if set, otherwise default-animals.png
          $picture = !empty($pet['picture']) ? $pet['picture'] : 'default-animals.png';
          $picturePath = "../img/" . htmlspecialchars($picture);
        ?>
          <div class="col">
            <div class="card paw-card paw-card--index h-100">
              <div class="paw-card-inner">
                <div class="paw-card-content">
                  <img src="<?= $picturePath ?>" 
                       class="paw-card-img" 
                       alt="<?= htmlspecialchars($pet['name']) ?>"
                       onerror="this.src='../img/default-animals.png'">
                  <div class="paw-card-title-wrapper">
                    <h5 class="paw-card-title"><?= htmlspecialchars($pet['name']) ?></h5>
                    <hr class="index-card-hr">
                    <p class="paw-card-meta">
                      <?= !empty($pet['short_description']) ? htmlspecialchars($pet['short_description']) : 'No description available.' ?>
                    </p>
                  </div>
                  <span class="badge bg-secondary">Adopted</span>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="alert alert-info">No pets have been adopted yet.</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Footer -->
  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
