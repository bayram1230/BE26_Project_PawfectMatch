<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Privacy Policy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2>Privacy Policy</h2>
    <p>At PawfectMatch, we respect your privacy and are committed to protecting your personal information.</p>
    <ul>
      <li>We collect only the information necessary to process adoption applications and improve our services.</li>
      <li>Your data will not be shared with third parties except partner shelters involved in the adoption process.</li>
      <li>We use secure methods to store and protect your information.</li>
      <li>You may request deletion of your account and associated data at any time.</li>
    </ul>
    <p>This policy may be updated periodically to reflect new practices or legal requirements.</p>
  </div>

  <!-- Footer -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
