<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Resources</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- Navbar OUTSIDE container -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2 class="mt-4">📚 Resources for New Adopters</h2>
    <p class="lead">Helpful tips and guides to make your adoption journey smooth and joyful.</p>

    <!-- Section 1 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>Preparing Your Home</h4>
        <ul>
          <li>Set up a quiet, safe space for your new pet.</li>
          <li>Remove hazards like toxic plants, loose wires, or small objects.</li>
          <li>Have food, water bowls, bedding, and toys ready before arrival.</li>
        </ul>
      </div>
    </div>

    <!-- Section 2 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>First Days Together</h4>
        <ul>
          <li>Give your pet time to adjust — don’t overwhelm them with visitors.</li>
          <li>Stick to a routine for feeding, walks, and playtime.</li>
          <li>Offer gentle affection and let them come to you at their own pace.</li>
        </ul>
      </div>
    </div>

    <!-- Section 3 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>Health & Care</h4>
        <ul>
          <li>Schedule a vet check‑up within the first week.</li>
          <li>Keep vaccinations and parasite prevention up to date.</li>
          <li>Provide balanced nutrition and fresh water daily.</li>
        </ul>
      </div>
    </div>

    <!-- Section 4 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>Training & Bonding</h4>
        <ul>
          <li>Use positive reinforcement — reward good behavior with treats or praise.</li>
          <li>Be patient and consistent with commands.</li>
          <li>Spend quality time together to build trust and companionship.</li>
        </ul>
      </div>
    </div>

    <!-- Section 5 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>Long‑Term Happiness</h4>
        <ul>
          <li>Provide regular exercise suited to your pet’s breed and age.</li>
          <li>Keep enrichment toys and activities to prevent boredom.</li>
          <li>Celebrate milestones — adoption anniversaries, birthdays, and achievements.</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Footer OUTSIDE container -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle for dropdowns -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
