<?php
session_start();

require_once __DIR__ . "/../../components/db_connect.php";
require_once __DIR__ . "/../functions/get_profile.php";
require_once "../../components/navbar.php";

/* ---------------------------------
   Profile picture
---------------------------------- */
if (isset($_SESSION['user_id'])) {
    $profilePic = getProfilePicture($conn);
} else {
    $profilePic = "default-users.png";
}

/* ---------------------------------
   Check ID
---------------------------------- */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<h3>No valid ID provided.</h3>");
}

$id = (int) $_GET['id'];

/* ---------------------------------
   DB query (SECURE)
---------------------------------- */
$sql = "SELECT * FROM animal WHERE ID = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$layout = "";

/* ---------------------------------
   Build layout
---------------------------------- */
if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    /* IMAGE handling */
    if (!empty($row['img'])) {
        $imgPath = (strpos($row['img'], 'http') === 0)
            ? $row['img']
            : "../../img/" . $row['img'];
    } else {
        $imgPath = "../../img/default-animals.png";
    }

    /* BUTTON logic */
    if (isset($_SESSION['user_id'])) {
        $buttonHtml = "
            <a href='../user/apply.php?id={$row['ID']}' class='details-inline-btn'>
               🐾 Take Me Home 🐾
            </a>
        ";
    } else {
        $buttonHtml = "
            <button class='details-inline-btn'
                    onclick=\"alert('You have to be logged in to take a pet home');\">
               🐾 Take Me Home 🐾
            </button>
        ";
    }

    $layout .= "
    <div class='col'>
    <div class='card paw-card paw-card--details'>
    <div class='paw-card-inner'>
      <div class='details-content'>

        <!-- LEFT COLUMN -->
        <div class='details-left'>

          <div class='details-media'>

            <div class='details-name-row'>
              <h2 class='details-name image-title'>" . htmlspecialchars($row['Name']) . "</h2>
            </div>

            <div class='details-image'>
              <img src='" . htmlspecialchars($imgPath) . "'
                   class='details-card-img'
                   alt='" . htmlspecialchars($row['Name']) . "'>
            </div>

            <div class='details-image-button'>
              " . $buttonHtml . "
            </div>

          </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class='details-right'>

          <div class='details-description-wrapper'>
            <h5>Description</h5>
            <p class='paw-card-meta'>" . nl2br(htmlspecialchars($row['Description'])) . "</p>
          </div>

          <div class='details-adoption-wrapper'>
            <h5>Adoption Requirements</h5>
            <p class='paw-card-meta'>" .
              (!empty($row['adoption_requirements'])
                ? nl2br(htmlspecialchars($row['adoption_requirements']))
                : 'No special adoption requirements.')
            . "</p>
          </div>

          <h5 class='details-table-title'>Characteristics</h5>

          <table class='details-table'>
            <tr>
              <th>Color:</th>
              <td><span class='value'>" . htmlspecialchars($row['Color']) . "</span></td>

              <th>Sex:</th>
              <td><span class='value'>" . htmlspecialchars($row['Sex']) . "</span></td>
            </tr>
            <tr>
              <th>Size:</th>
              <td><span class='value'>" . htmlspecialchars($row['Size']) . "</span></td>

              <th>Age:</th>
              <td><span class='value'>" . htmlspecialchars($row['Age']) . "</span></td>
            </tr>
            <tr>
              <th>Breed:</th>
              <td><span class='value'>" . htmlspecialchars($row['Breed']) . "</span></td>

              <th>Type:</th>
              <td><span class='value'>" . htmlspecialchars($row['Type']) . "</span></td>
            </tr>
          </table>

        </div>

      </div>
    </div>
    </div>
    </div>
    ";
} else {
    $layout = "<h3>No data found.</h3>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="body-pic">
 <!-- HERO -->
    <header class="hero-section">
        <div class="hero-outro">
            <div class="hero-outro-content">
                <img
                    src="../../img/logo.png"
                    class="hero-outro-logo"
                    alt="PawfectMatch Logo"
                >
                <p class="hero-subtitle hero-outro-subtitle">
                    Everyone deserves a pawfect home
                </p>
            </div>
        </div>
    </header>

<!-- Main Content -->
<div class="container details-container">
    <a href="/index.php" class="details-back-button">
  <i class="fa-solid fa-house"></i>
  <span>Back to Home</span>
</a>



    <div class="row">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const hero = document.querySelector(".hero-section");
  const outro = document.querySelector(".hero-outro");

  if (!hero || !outro) return;

  // minimaler Tick, damit Browser Initialzustand rendert
  requestAnimationFrame(() => {
    hero.classList.add("outro-active");
    outro.classList.add("active");
  });
});
</script>

</body>
</html>
