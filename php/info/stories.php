<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
/* Navbar is alongside this file */

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Adoption Stories</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap + FontAwesome + Shared CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <!-- AdoptionStories.php is in /php/, so css is one level up -->
  <link href="../../css/style.css" rel="stylesheet">
  <style>
    .index-container { padding-bottom: 140px; }
    /* Equal height cards */
    .story-row {
      display: flex;
      flex-wrap: wrap;
    }
    .story-card {
      display: flex;
      flex-direction: column;
      height: 100%;
    }
    .story-card img {
      max-height: 220px;
      object-fit: cover;
    }
    .story-card .card-body {
      flex-grow: 1;
      overflow: visible;
      white-space: normal;
    }
  </style>
</head>
<body class="body-pic">
  <div class="container index-container mt-5">
    <h2 class="paw-card-h1 text-white text-center mb-3"
        style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
      :pfoten: Adoption Stories
    </h2>
    <p class="lead text-white text-center mb-4" style="opacity: 0.9;">
      Read inspiring stories from families who found their perfect match through PawfectMatch.
    </p>
    <div class="row mt-4 story-row">
      <!-- Story 1 -->
      <div class="col-md-4 mb-4 d-flex">
        <div class="card shadow text-center story-card w-100">
          <img src="../img/max.png" alt="Max the Labrador"
               class="img-fluid rounded mx-auto d-block mb-3"
               onerror="this.src='../img/default-animals.png'">
          <div class="card-body">
            <h4 class="card-title">Max the Labrador</h4>
            <p class="card-text">
              Max was rescued from a crowded shelter and is now thriving with his new family in Vienna.
              His playful energy has brought laughter to the children, and his loyalty has given the parents
              a sense of security. Max’s journey shows how adopting a young, energetic dog can transform
              a household into a happier, more active home.
            </p>
          </div>
        </div>
      </div>
      <!-- Story 2 -->
      <div class="col-md-4 mb-4 d-flex">
        <div class="card shadow text-center story-card w-100">
          <img src="../img/luna.png" alt="Luna the Cat"
               class="img-fluid rounded mx-auto d-block mb-3"
               onerror="this.src='../img/default-animals.png'">
          <div class="card-body">
            <h4 class="card-title">Luna the Cat</h4>
            <p class="card-text">
              Luna was timid and hid under the couch for weeks, but her adopters gave her patience and love.
              With gentle encouragement, she slowly came out of her shell. Today, Luna curls up on laps,
              greets visitors at the door, and has become the heart of her household. Her story proves that
              shy pets blossom when given time and trust.
            </p>
          </div>
        </div>
      </div>
      <!-- Story 3 -->
      <div class="col-md-4 mb-4 d-flex">
        <div class="card shadow text-center story-card w-100">
          <img src="../img/rocky.png" alt="Rocky the Senior Dog"
               class="img-fluid rounded mx-auto d-block mb-3"
               onerror="this.src='../img/default-animals.png'">
          <div class="card-body">
            <h4 class="card-title">Rocky the Senior Dog</h4>
            <p class="card-text">
              Rocky spent years overlooked because of his age, but a foster‑to‑adopt family gave him a chance.
              They provided soft bedding, gentle walks, and endless affection. Rocky now enjoys his golden years
              surrounded by love, proving that senior pets bring wisdom, calm, and deep companionship to any home.
            </p>
          </div>
        </div>
      </div>
    </div>
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
  <?php include __DIR__ . '/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>