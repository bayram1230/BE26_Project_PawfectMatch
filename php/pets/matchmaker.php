<?php

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

$matchRow = null;
$matchMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $activity   = $_POST['activity'] ?? '';
    $home       = $_POST['home'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $petType    = $_POST['pet_type'] ?? '';
    $agePref    = $_POST['age_pref'] ?? '';

    if (
        empty($activity) &&
        empty($home) &&
        empty($experience) &&
        empty($petType) &&
        empty($agePref)
    ) {
        $matchMsg = "Please select at least one option before finding your match.";
    } else {

        // BASIS: nur verfügbare Tiere (keine Adoption / Foster Historie)
        $sql = "
        SELECT a.*
        FROM animal a
        LEFT JOIN adoptionhistory ah ON ah.AnimalID = a.ID
        WHERE ah.ID IS NULL
        ";

        // Tierart
        if ($petType === "Dog") {
            $sql .= " AND a.Type = 'Dog'";
        } elseif ($petType === "Cat") {
            $sql .= " AND a.Type = 'Cat'";
        } elseif ($petType === "Other") {
            $sql .= " AND a.Type = 'Other'";
        }

        // Lifestyle / Erfahrung / Alter
        if ($activity === "active" && $home === "house") {
            $sql .= " AND a.Size = 'Large' AND a.Type = 'Dog'";
        } elseif ($activity === "calm" && $home === "apartment") {
            $sql .= " AND (a.Type = 'Cat' OR a.Size = 'Small')";
        } elseif ($experience === "first") {
            $sql .= " AND a.Age <= 4";
        } elseif ($experience === "experienced") {
            $sql .= " AND (a.Age >= 5 OR a.Size = 'Large')";
        } elseif ($agePref === "young") {
            $sql .= " AND a.Age <= 2";
        } elseif ($agePref === "senior") {
            $sql .= " AND a.Age >= 8";
        }

        $sql .= " ORDER BY RAND() LIMIT 1";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $matchRow = mysqli_fetch_assoc($result);
        } else {
            $matchMsg = "Sorry, no pets currently match your criteria.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pet Matchmaker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link href="../../css/style.css" rel="stylesheet">
  <style>
    body { margin-bottom: 100px; }
    .match-img { max-height: 250px; object-fit: cover; }
  </style>
</head>

<body class="body-pic">
<div class="container index-container mt-5">

<h2 class="paw-card-h1 text-white text-center mb-3">
  🏹 Pet Matchmaker Quiz
</h2>

<p class="lead text-white text-center mb-4">
  Answer a few quick questions to find your perfect pet match!
</p>

<!-- Quiz Form -->
    <form method="POST" class="mt-4">
      <div class="mb-3">
        <label class="form-label text-white">Your lifestyle:</label>
        <select name="activity" class="form-select">
          <option value="">-- Select --</option>
          <option value="active">Active (love walks, outdoors)</option>
          <option value="calm">Calm (prefer quiet, relaxed)</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Your home type:</label>
        <select name="home" class="form-select">
          <option value="">-- Select --</option>
          <option value="house">House with yard</option>
          <option value="apartment">Apartment/flat</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Pet ownership experience:</label>
        <select name="experience" class="form-select">
          <option value="">-- Select --</option>
          <option value="first">First-time owner</option>
          <option value="experienced">Experienced owner</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Preferred pet type:</label>
        <select name="pet_type" class="form-select">
          <option value="">-- Select --</option>
          <option value="Dog">Dog</option>
          <option value="Cat">Cat</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Age preference:</label>
        <select name="age_pref" class="form-select">
          <option value="">-- Select --</option>
          <option value="young">Young animal</option>
          <option value="adult">Adult</option>
          <option value="senior">Senior</option>
        </select>
      </div>
      <button type="submit" class="btn paw-card-btn">Find My Match</button>
    </form>

<?php if (!empty($matchMsg)): ?>
  <div class="alert alert-info mt-4"><?= htmlspecialchars($matchMsg) ?></div>
<?php endif; ?>

<?php if ($matchRow): ?>
  <div class="card mt-4">
    <h4 class="card-header"><?= htmlspecialchars($matchRow['Name']) ?></h4>

    <img
      src="../img/<?= htmlspecialchars($matchRow['ImageUrl'] ?? 'default-animals.png') ?>"
      class="img-fluid rounded mx-auto d-block mb-3 match-img"
      onerror="this.src='../img/default-animals.png'"
    >

    <div class="card-body">
      <p class="card-text">
        <?= htmlspecialchars($matchRow['Description'] ?? 'No description available.') ?><br>
        <strong>Type:</strong> <?= htmlspecialchars($matchRow['Type']) ?><br>
        <strong>Age:</strong> <?= htmlspecialchars($matchRow['Age']) ?> years
      </p>

      <a href="details.php?id=<?= (int)$matchRow['ID'] ?>" class="btn paw-card-btn">
        Learn More
      </a>
    </div>
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
</body>
</html>
