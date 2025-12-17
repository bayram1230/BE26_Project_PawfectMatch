<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

$events = [];
$sql = "SELECT * FROM volunteer_events ORDER BY event_date ASC";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
    }
} else {
    // Query failed (likely table missing)
    $errorMsg = "Volunteer events table not found. Please create 'volunteer_events' in the database.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Volunteer Opportunities</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + FontAwesome + Shared CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link href="../css/style.css" rel="stylesheet">

  <style>
    footer { position: fixed; bottom: 0; left: 0; width: 100%; padding: 1rem 0; }
    body { margin-bottom: 100px; }
    .index-container { padding-bottom: 140px; }
    .volunteer-card { border-radius: .5rem; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15); }
    .volunteer-card .card-header { font-weight: bold; text-align: center; }
  </style>
</head>
<body class="body-pic">
  <div class="container index-container mt-5">
    <h2 class="paw-card-h1 text-white text-center mb-3"
        style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
      🐾 Volunteer Opportunities
    </h2>
    <p class="lead text-white text-center mb-4" style="opacity: 0.9;">
      Join us in making a difference! PawfectMatch offers several ways to volunteer and support pets in need.
    </p>

    <?php if (!empty($events)): ?>
      <?php foreach ($events as $event): ?>
        <div class="card volunteer-card mb-4">
          <h4 class="card-header"><?= htmlspecialchars($event['title']) ?></h4>
          <div class="card-body text-center">
            <p class="card-text">
              <strong>Date:</strong> <?= htmlspecialchars($event['event_date']) ?><br>
              <strong>Location:</strong> <?= htmlspecialchars($event['location']) ?><br>
              <?= !empty($event['description']) ? htmlspecialchars($event['description']) : 'No description available.' ?>
            </p>
            <a href="signup.php?event_id=<?= intval($event['id']) ?>" class="btn paw-card-btn">Sign Up</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php elseif (isset($errorMsg)): ?>
      <div class="alert alert-danger text-center"><?= $errorMsg ?></div>
    <?php else: ?>
      <div class="alert alert-warning text-center">No volunteer events available right now. Check back soon!</div>
    <?php endif; ?>
  </div>

  <!-- Footer -->
  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
