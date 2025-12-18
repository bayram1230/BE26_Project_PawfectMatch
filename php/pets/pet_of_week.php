<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Includes – korrekt von /php/pets/ */
require_once __DIR__ . '/../../components/db_connect.php';
require_once __DIR__ . '/../functions/get_profile.php';
require_once __DIR__ . '/../../components/navbar.php';

/* Role & profile picture */
$role = $_SESSION['role'] ?? 'guest';
if (isset($_SESSION['username'])) {
    $profilePic = getProfilePicture($conn);
} else {
    $profilePic = "default-users.png";
}

/* SQL: aktuelles Pet of the Week */
$sql = "
SELECT a.*
FROM animal a
JOIN pet_of_week pow ON pow.AnimalID = a.ID
ORDER BY pow.created_at DESC
LIMIT 1
";

$result = mysqli_query($conn, $sql);
$pet = ($result && mysqli_num_rows($result) > 0)
    ? mysqli_fetch_assoc($result)
    : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pet of the Week</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

  <!-- CSS -->
  <link href="../../css/style.css" rel="stylesheet">

  <style>
    body { margin-bottom: 120px; }
    .index-container { padding-bottom: 140px; }
    .paw-card-img {
      max-width: 320px;
      height: auto;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .paw-card-img:hover { transform: scale(1.05); }
  </style>
</head>

<body class="body-pic">

<div class="container index-container mt-5">

  <h2 class="paw-card-h1 text-white text-center mb-3">
    🐾 Pet of the Week
  </h2>

  <p class="lead text-white text-center mb-4">
    Each week we highlight one special pet looking for a forever home.
  </p>

  <?php if ($pet): ?>

    <?php
      $picture = !empty($pet['ImageUrl']) ? $pet['ImageUrl'] : 'default-animals.png';
      $picturePath = "../../img/" . htmlspecialchars($picture);
    ?>

    <div class="card paw-card paw-card--index shadow text-center">
      <div class="card-body">

        <h3 class="paw-card-h1 mb-3">
          <?= htmlspecialchars($pet['Name']) ?>
        </h3>

        <img
          src="<?= $picturePath ?>"
          alt="<?= htmlspecialchars($pet['Name']) ?>"
          class="img-fluid mx-auto d-block rounded mb-3 paw-card-img"
          onerror="this.src='../../img/default-animals.png'"
        >

        <p class="text-white">
          <?= !empty($pet['Description'])
              ? htmlspecialchars($pet['Description'])
              : 'No description available.' ?>
          <br><strong>Type:</strong> <?= htmlspecialchars($pet['Type']) ?>
          <br><strong>Age:</strong> <?= htmlspecialchars($pet['Age']) ?> years
        </p>

        <a href="../crud/details.php?id=<?= (int)$pet['ID'] ?>" class="btn paw-card-btn">
          Learn More
        </a>

      </div>
    </div>

  <?php else: ?>

    <div class="alert alert-warning text-center">
      No Pet of the Week available right now.
    </div>

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
