<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Terms & Conditions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2>Terms & Conditions</h2>
    <p>Welcome to PawfectMatch. By using our platform, you agree to the following terms:</p>
    <ul>
      <li>All adoption applications are subject to review and approval by our partner shelters.</li>
      <li>Users must provide accurate information when registering or applying for adoption.</li>
      <li>PawfectMatch is not liable for agreements made directly between adopters and shelters.</li>
      <li>Content shared on the platform must respect community guidelines and animal welfare standards.</li>
    </ul>
    <p>These terms may be updated periodically. Please check back regularly for changes.</p>
  </div>

  <!-- Footer -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
