<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2>About PawfectMatch</h2>
    <p>PawfectMatch is dedicated to connecting pets with loving families. Our mission is to make adoption easier, provide resources for pet care, and share inspiring stories of successful matches.</p>
    <p>Founded in 2025, we work with shelters, volunteers, and communities to ensure every pet finds a safe and happy home.</p>
  </div>

  <!-- Footer -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
