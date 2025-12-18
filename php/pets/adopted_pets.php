<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Includes – identisch zu fostered_pets.php
require_once __DIR__ . '/../../components/db_connect.php';
require_once __DIR__ . '/../functions/get_profile.php';
require_once __DIR__ . '/../../components/navbar.php';

// SQL: Tiere, deren LETZTER Status = Completed (adopted)
$sql = "
SELECT a.*
FROM animal a
JOIN adoptionhistory ah ON ah.AnimalID = a.ID
WHERE ah.ID = (
    SELECT MAX(ID)
    FROM adoptionhistory
    WHERE AnimalID = a.ID
)
AND ah.Status = 'Completed'
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('SQL Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Adopted Pets</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

  <!-- Project CSS -->
  <link rel="stylesheet" href="../../css/style.css">

  <style>
    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 1rem 0;
    }
    body {
      margin-bottom: 100px;
    }
  </style>
</head>

<body class="body-pic">

<div class="container index-container mt-5">

  <h2 class="paw-card-h1 text-white text-center mb-3"
      style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
    🏡 Adopted Pets
  </h2>

  <p class="lead text-white text-center mb-4" style="opacity: 0.9;">
    These pets have already been adopted and are enjoying their new homes.
  </p>

  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($pet = mysqli_fetch_assoc($result)): ?>

        <?php
          // korrekte Spaltennamen aus der animal-Tabelle
          $picture = !empty($pet['ImageUrl']) ? $pet['ImageUrl'] : 'default-animals.png';
          $picturePath = "../../img/" . htmlspecialchars($picture);
        ?>

        <div class="col">
          <div class="card paw-card paw-card--index h-100">
            <div class="paw-card-inner">
              <div class="paw-card-content">

                <img
                  src="<?= $picturePath ?>"
                  class="paw-card-img"
                  alt="<?= htmlspecialchars($pet['Name']) ?>"
                  onerror="this.src='../../img/default-animals.png'"
                >

                <div class="paw-card-title-wrapper">
                  <h5 class="paw-card-title">
                    <?= htmlspecialchars($pet['Name']) ?>
                  </h5>
                  <hr class="index-card-hr">
                  <p class="paw-card-meta">
                    <?= !empty($pet['Description'])
                        ? htmlspecialchars($pet['Description'])
                        : 'No description available.' ?>
                  </p>
                </div>

                <span class="badge bg-secondary mt-2">
                  Adopted
                </span>

              </div>
            </div>
          </div>
        </div>

      <?php endwhile; ?>
    <?php else: ?>

      <div class="alert alert-info text-center">
        No pets have been adopted yet.
      </div>

    <?php endif; ?>

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

</body>
</html>
