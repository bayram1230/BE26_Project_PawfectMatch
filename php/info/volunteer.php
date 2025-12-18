<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Functions are inside /php/functions/ */
// Includes
require_once __DIR__ . '/../../components/db_connect.php';
require_once __DIR__ . '/../functions/get_profile.php';
require_once __DIR__ . '/../../components/navbar.php';

$role = $_SESSION['role'] ?? 'guest';
if (isset($_SESSION['username'])) {
    $profilePic = getProfilePicture($conn);
} else {
    $profilePic = "default-users.png";
}

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
  <!-- Volunteer.php is in /php/, so css is one level up -->
  <link href="../../css/style.css" rel="stylesheet">
  <style>
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
      :pfoten: Volunteer Opportunities
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
            <!-- Add aria-label so link has discernible text -->
            <a href="signup.php?event_id=<?= intval($event['id']) ?>" class="btn paw-card-btn" aria-label="Sign up for <?= htmlspecialchars($event['title']) ?>">Sign Up</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php elseif (isset($errorMsg)): ?>
      <div class="alert alert-danger text-center"><?= $errorMsg ?></div>
    <?php else: ?>
      <div class="alert alert-warning text-center">No volunteer events available right now. Check back soon!</div>
    <?php endif; ?>
  </div>
  <!-- FOOTER -->
    <footer class="mt-auto">
        <div class="social-icons text-center mb-3">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="#"><i class="fab fa-x-twitter"></i></a>
        </div>
        <div class="newsletter text-center my-3">
            <form class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                <label class="form-label footer-info mb-0">Sign up for our newsletter</label>
                <input type="email" class="form-control newsletter-sign-up-box" placeholder="Enter your email">
                <button type="submit" class="btn subscribe">Subscribe</button>
            </form>
        </div>
        <div class="text-center mb-3">
            <a href="contact.php" class="me-3 footer-info">Contact</a>
            <a href="about.php" class="me-3 footer-info">About</a>
            <a href="terms.php" class="me-3 footer-info">Terms & Conditions</a>
            <a href="privacy.php" class="footer-info">Privacy Policy</a>
        </div>
        <div class="copyright footer-info">
            © 2025 Copyright: Group 1
        </div>
    </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
