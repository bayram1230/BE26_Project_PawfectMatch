<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

$matchResult = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $activity   = $_POST['activity'] ?? '';
    $home       = $_POST['home'] ?? '';
    $experience = $_POST['experience'] ?? '';

    if (empty($activity) && empty($home) && empty($experience)) {
        // User clicked submit without choosing anything
        $matchResult = "⚠️ Please select at least one option before finding your match.";
    } else {
        // Build SQL query based on answers
        if ($activity === "active" && $home === "house") {
            $sql = "SELECT * FROM pets 
                    WHERE size='Large' AND breed NOT LIKE '%Cat%' 
                    AND status='available' 
                    ORDER BY RAND() LIMIT 1";
        } elseif ($activity === "calm" && $home === "apartment") {
            $sql = "SELECT * FROM pets 
                    WHERE (breed LIKE '%Cat%' OR size='Small') 
                    AND status='available' 
                    ORDER BY RAND() LIMIT 1";
        } elseif ($experience === "first") {
            $sql = "SELECT * FROM pets 
                    WHERE neutered='Yes' AND age <= 4 
                    AND status='available' 
                    ORDER BY RAND() LIMIT 1";
        } elseif ($experience === "experienced") {
            $sql = "SELECT * FROM pets 
                    WHERE (age >= 5 OR size='Large') 
                    AND status='available' 
                    ORDER BY RAND() LIMIT 1";
        } else {
            // Default → any available pet (only if at least one option chosen)
            $sql = "SELECT * FROM pets 
                    WHERE status='available' 
                    ORDER BY RAND() LIMIT 1";
        }

        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $matchResult = "✨ Your match is <a href='details.php?id=" 
                . intval($row['id']) . "' class='link-success'>" 
                . htmlspecialchars($row['name']) 
                . (!empty($row['breed']) ? " (" . htmlspecialchars($row['breed']) . ")" : "") 
                . "</a>!";
        } else {
            $matchResult = "😿 Sorry, no pets currently match your criteria. Please check back later!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pet Matchmaker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar OUTSIDE container -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2 class="mt-4">💘 Pet Matchmaker Quiz</h2>
    <p class="lead">Answer a few quick questions to find your perfect pet match!</p>

    <form method="POST" class="mt-4">
      <div class="mb-3">
        <label class="form-label">Your lifestyle:</label>
        <select name="activity" class="form-select">
          <option value="">-- Select --</option>
          <option value="active">Active (love walks, outdoors)</option>
          <option value="calm">Calm (prefer quiet, relaxed)</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Your home type:</label>
        <select name="home" class="form-select">
          <option value="">-- Select --</option>
          <option value="house">House with yard</option>
          <option value="apartment">Apartment/flat</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Pet ownership experience:</label>
        <select name="experience" class="form-select">
          <option value="">-- Select --</option>
          <option value="first">First-time owner</option>
          <option value="experienced">Experienced owner</option>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Find My Match</button>
    </form>

    <?php if (!empty($matchResult)): ?>
      <div class="alert alert-info mt-4">
        <?= $matchResult ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Footer OUTSIDE container -->
  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
