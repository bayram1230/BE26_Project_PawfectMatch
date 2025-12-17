<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

// Get Pet of the Week explicitly
$sql = "SELECT * FROM pets WHERE status='pet_of_week' LIMIT 1";
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + FontAwesome + Shared CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link href="../css/style.css" rel="stylesheet">

  <style>
    footer { position: fixed; bottom: 0; left: 0; width: 100%; padding: 1rem 0; }
    body { margin-bottom: 120px; }
    .index-container { padding-bottom: 140px; }
    .paw-card-img { max-width: 320px; height: auto; object-fit: cover; transition: transform 0.3s ease; }
    .paw-card-img:hover { transform: scale(1.05); }
    .paw-card-text { color: #000; } /* ✅ force card text to black */
    .paw-card-h1 { color: #000; }   /* ✅ headings inside card black */
  </style>
</head>
<body class="body-pic">
  <div class="container index-container mt-5">
    <h2 class="paw-card-h1 text-center mb-3"
        style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
      🐾 Pet of the Week
    </h2>
    <p class="lead text-center mb-4" style="opacity: 0.9; color:#000;">
      Each week we highlight one special pet looking for a forever home.
    </p>

    <?php if ($pet): ?>
      <div class="card paw-card paw-card--index shadow text-center">
        <div class="card-body paw-card-text">
          <h3 class="paw-card-h1 mb-3"><?= htmlspecialchars($pet['name']) ?></h3>
          <img src="../img/<?= htmlspecialchars(!empty($pet['ImageUrl']) ? $pet['ImageUrl'] : 'default-animals.png') ?>" 
               alt="<?= htmlspecialchars($pet['name']) ?>" 
               class="img-fluid mx-auto d-block rounded mb-3 paw-card-img"
               onerror="this.src='../img/default-animals.png'">
          <p>
            <?= !empty($pet['short_description']) ? htmlspecialchars($pet['short_description']) : 'No description available.' ?><br>
            <strong>Breed:</strong> <?= !empty($pet['breed']) ? htmlspecialchars($pet['breed']) : 'Unknown' ?><br>
            <strong>Age:</strong> <?= htmlspecialchars($pet['age']) ?> years<br>
            <?php if (isset($pet['location'])): ?>
              <strong>Location:</strong> <?= !empty($pet['location']) ? htmlspecialchars($pet['location']) : 'Not specified' ?>
            <?php endif; ?>
          </p>
          <a href="details.php?id=<?= intval($pet['id']) ?>" class="btn paw-card-btn">Learn More</a>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">No Pet of the Week available right now.</div>
    <?php endif; ?>
  </div>

  <?php include __DIR__ . '/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
