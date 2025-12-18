<?php
session_start();
require_once __DIR__ . '/../../components/db_connect.php';
require_once __DIR__ . '/../functions/get_profile.php';
require_once __DIR__ . '/../../components/navbar.php';
/**
 * Sicherstellen, dass niemals NULL an htmlspecialchars() geht
 */
$success = (isset($_GET['success']) && $_GET['success'] === '1');
$error   = isset($_GET['error']) ? (string)$_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

  <!-- WICHTIG: du bist in php/contact/ -> 2 Ebenen hoch zur css -->
  <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="body-pic">

<main class="container contact-container">
  <div class="paw-card contact-card">
    <div class="paw-card-inner contact-inner">

      <div class="contact-head">
        <h1 class="contact-title">Contact Us</h1>
        <p class="contact-subtitle">We will get back to you asap!</p>
      </div>

      <?php if ($success): ?>
        <div class="alert alert-success text-center contact-alert">
          Message sent successfully ✅
        </div>
      <?php elseif ($error !== ''): ?>
        <div class="alert alert-danger text-center contact-alert">
          <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endif; ?>

      <!-- WICHTIG: contact_send.php liegt im gleichen Ordner -->
      <form action="contact_send.php" method="POST" class="contact-form">
        <div class="row g-3">

          <div class="col-md-6">
            <div class="input-group contact-input-group">
              <span class="input-group-text contact-icon">
                <i class="fa-solid fa-user"></i>
              </span>
              <input type="text" name="first_name" class="form-control contact-input" placeholder="First Name" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group contact-input-group">
              <span class="input-group-text contact-icon">
                <i class="fa-solid fa-user"></i>
              </span>
              <input type="text" name="last_name" class="form-control contact-input" placeholder="Last Name" required>
            </div>
          </div>

          <div class="col-12">
            <div class="input-group contact-input-group">
              <span class="input-group-text contact-icon">
                <i class="fa-solid fa-envelope"></i>
              </span>
              <input type="email" name="email" class="form-control contact-input" placeholder="Email" required>
            </div>
          </div>

          <div class="col-12">
            <div class="input-group contact-input-group">
              <span class="input-group-text contact-icon">
                <i class="fa-solid fa-phone"></i>
              </span>
              <input type="text" name="phone" class="form-control contact-input" placeholder="Phone">
            </div>
          </div>

          <div class="col-12">
            <textarea name="message" class="form-control contact-textarea" rows="5" placeholder="Your message..." required></textarea>
          </div>

          <div class="col-12">
            <button type="submit" class="btn contact-btn">Send</button>
          </div>

        </div>
      </form>

      <p class="contact-bottom">
        You may also call us at <span>333-33-33</span>
      </p>

    </div>
  </div>
</main>
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
