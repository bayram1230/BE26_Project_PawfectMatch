<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Includes (Pfad ist korrekt für deine Struktur)
require_once __DIR__ . '/../../components/db_connect.php';
require_once __DIR__ . '/../functions/get_profile.php';
require_once __DIR__ . '/../../components/navbar.php';

$eventId = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$event = null;
$message = "";
if ($eventId > 0) {
    $sql = "SELECT * FROM volunteer_events WHERE id = $eventId";
    $result = mysqli_query($conn, $sql);
    $event = $result && mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : null;
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $event) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $insert = "INSERT INTO volunteer_signups (event_id, name, email)
               VALUES ($eventId, '$name', '$email')";
    if (mysqli_query($conn, $insert)) {
        $message = ":weißes_häkchen: Thank you, $name! You are signed up for " . htmlspecialchars($event['title']) . ".";
    } else {
        $message = ":x: Error saving your signup. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Volunteer Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../css/style.css" rel="stylesheet">
  <style>
    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 1rem 0;
    }
    body {
      margin-bottom: 120px; /* prevent overlap with sticky footer */
    }
    .index-container {
      padding-bottom: 140px; /* extra space so footer doesn't block content */
    }
  </style>
</head>
<body class="body-pic">
  <div class="container index-container mt-5">
    <?php if (!empty($event)): ?>
      <h2 class="text-white mb-3">Sign Up for <?= htmlspecialchars($event['title']) ?></h2>
      <p class="text-white">
        <strong>Date:</strong> <?= htmlspecialchars($event['event_date']) ?><br>
        <strong>Location:</strong> <?= htmlspecialchars($event['location']) ?><br>
      </p>
      <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= $message ?></div>
      <?php endif; ?>
      <form method="post" action="">
        <div class="mb-3">
          <label class="form-label text-white">Your Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label text-white">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn paw-card-btn">Submit</button>
      </form>
    <?php else: ?>
      <div class="alert alert-danger">Event not found.</div>
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
