<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Volunteer Opportunities</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- Navbar OUTSIDE container -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2 class="mt-4">🐾 Volunteer Opportunities</h2>
    <p class="lead">Join us in making a difference! PawfectMatch offers several ways to volunteer and support pets in need:</p>

    <!-- Volunteer Options -->
    <div class="row mt-4">
      <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-body">
            <h4 class="card-title">Shelter Support</h4>
            <p class="card-text">Help with feeding, walking, and caring for pets at local shelters.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-body">
            <h4 class="card-title">Event Assistance</h4>
            <p class="card-text">Volunteer at adoption fairs and fundraising events.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-body">
            <h4 class="card-title">Transport</h4>
            <p class="card-text">Assist with safely transporting pets to foster homes or vet appointments.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-body">
            <h4 class="card-title">Foster Care</h4>
            <p class="card-text">Provide temporary homes for pets until they are adopted.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Upcoming Events -->
    <h4 class="mt-4">Upcoming Volunteer Events</h4>
    <p>📅 Check back soon for our volunteer calendar with dates and opportunities near you.</p>
  </div>

  <!-- Footer OUTSIDE container -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle for dropdowns -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
