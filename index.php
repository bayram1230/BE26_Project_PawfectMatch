<?php
session_start(); // 👈 IMMER ALS ERSTES

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "components/db_connect.php";
require_once "php/functions/get_profile.php";

/* Rolle (guest | user | admin | shelter) */
$role = $_SESSION['role'] ?? 'guest';

/* Profilbild bestimmen */
if (isset($_SESSION['username'])) {
    $profilePic = getProfilePicture($conn);
} else {
    $profilePic = "default-users.png";
}


/* Navbar laden (nutzt $role & $profilePic) */
require_once "components/navbar.php";



/* DB */
$sql = "SELECT * FROM Animal";
$result = mysqli_query($conn, $sql);

$layout = "";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        if (!empty($row['img'])) {
            if (strpos($row['img'], 'http') === 0) {
                $imgPath = $row['img'];
            } else {
                $imgPath = "img/" . $row['img'];
            }
        } else {
            $imgPath = "img/default-animals.png";
        }

        $layout .= "
        <div class='col'>
            <div class='card paw-card paw-card--index'>
                <div class='paw-card-inner'>
                    <div class='paw-card-content'>
                        <img
                            src='" . htmlspecialchars($imgPath) . "'
                            class='paw-card-img'
                            alt='" . htmlspecialchars($row['Name']) . "'
                            onerror=\"this.src='img/default-animals.png'\"
                        >
                        <div class='paw-card-title-wrapper'>
                            <h5 class='paw-card-title'>" . htmlspecialchars($row['Name']) . "</h5>
                            <hr class='index-card-hr'>
                            <p class='paw-card-meta'>
                                Breed: " . htmlspecialchars($row['Type']) . "
                            </p>
                        </div>
                        <a
                            href='php/crud/details.php?id={$row['ID']}'
                            class='btn paw-card-btn'
                        >
                            🐾 More Details 🐾
                        </a>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
} else {
    $layout = "<h3 class='my-3'>No animals found</h3>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawfectMatch</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="body-pic">
    <!-- NAVBAR -->

    <!-- HERO -->
    <header class="hero-section">
        <video id="heroVideo" muted playsinline preload="auto">
            <source src="video/header.mp4" type="video/mp4">
        </video>
        <div class="hero-outro">
            <div class="hero-outro-content">
                <img
                    src="img/logo.png"
                    class="hero-outro-logo"
                    alt="PawfectMatch Logo"
                >
                <p class="hero-subtitle hero-outro-subtitle">
                    Everyone deserves a pawfect home
                </p>
            </div>
        </div>
    </header>
    <!-- MAIN CONTENT -->
    <div class="container index-container">
        <h1 class="paw-card-h1">Current list of available pets</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?= $layout ?>
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
    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
  document.addEventListener("DOMContentLoaded", () => {
  const hero = document.querySelector('.hero-section');
  const outro = document.querySelector('.hero-outro');
  const video = document.getElementById('heroVideo');

  if (!hero || !outro || !video) return;

  const SHOW_DELAY = 2500;     
  const CUT_SECONDS = 2;       
  const FADE_DURATION = 1.8;   

  let outroScheduled = false;

  video.pause();
  video.currentTime = 0;

  setTimeout(() => {
    video.classList.add('video-visible');
    video.play().catch(() => {});
  }, SHOW_DELAY);

  video.addEventListener('playing', () => {
    if (outroScheduled) return;
    outroScheduled = true;

    const duration = video.duration;
    if (!duration || isNaN(duration)) return;

    const fadeStartMs =
      (duration - CUT_SECONDS - FADE_DURATION) * 1000;

    setTimeout(() => {
      hero.classList.add('outro-active');
      outro.classList.add('active');
    }, fadeStartMs);

    setTimeout(() => {
      video.pause();
    }, fadeStartMs + FADE_DURATION * 1000);
  });
});
</script>
</body>
</html>