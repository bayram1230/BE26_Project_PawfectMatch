<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

// Get Pet of the Day explicitly
$sqlDay = "SELECT * FROM pets WHERE status='pet_of_day' LIMIT 1";
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
    .paw-card-text { color:#000; } /* ✅ force card text black */
    .paw-card-h1 { color:#000; }   /* ✅ headings black */
  </style>
</head>
<body class="body-pic">
  <div class="container index-container mt-5">
    <h2 class="paw-card-h1 text-center mb-3"
        style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
      🌟 Pet of the Day
    </h2>
    <p class="lead text-center mb-4" style="opacity: 0.9; color:#fff;">
  Every day we showcase a different pet waiting for a loving home.
</p>


    <?php if ($petDay): ?>
      <div class="card paw-card paw-card--index shadow text-center">
        <div class="card-body paw-card-text">
          <h3 class="paw-card-h1 mb-3"><?= htmlspecialchars($petDay['name']) ?></h3>
          <img src="../img/<?= htmlspecialchars(!empty($petDay['ImageUrl']) ? $petDay['ImageUrl'] : 'default-animals.png') ?>" 
               alt="<?= htmlspecialchars($petDay['name']) ?>" 
               class="img-fluid mx-auto d-block rounded mb-3 paw-card-img"
               onerror="this.src='../img/default-animals.png'">
          <p>
            <?= !empty($petDay['short_description']) ? htmlspecialchars($petDay['short_description']) : 'No description available.' ?><br>
            <strong>Breed:</strong> <?= !empty($petDay['breed']) ? htmlspecialchars($petDay['breed']) : 'Unknown' ?><br>
            <strong>Age:</strong> <?= htmlspecialchars($petDay['age']) ?> years<br>
            <?php if (isset($petDay['location'])): ?>
              <strong>Location:</strong> <?= !empty($petDay['location']) ? htmlspecialchars($petDay['location']) : 'Not specified' ?>
            <?php endif; ?>
          </p>
          <a href="details.php?id=<?= intval($petDay['id']) ?>" class="btn paw-card-btn">Learn More</a>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">No Pet of the Day available right now.</div>
    <?php endif; ?>
  </div>

  <?php include __DIR__ . '/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
