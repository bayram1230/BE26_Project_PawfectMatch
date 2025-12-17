<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

$matchRow = null;
$matchMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $activity   = $_POST['activity'] ?? '';
    $home       = $_POST['home'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $petType    = $_POST['pet_type'] ?? '';
    $agePref    = $_POST['age_pref'] ?? '';

    if (empty($activity) && empty($home) && empty($experience) && empty($petType) && empty($agePref)) {
        $matchMsg = "⚠️ Please select at least one option before finding your match.";
    } else {
        // Default query
        $sql = "SELECT * FROM animal WHERE status='available' ORDER BY RAND() LIMIT 1";

        // Pet type has priority
        if ($petType === "Dog") {
            $sql = "SELECT * FROM animal WHERE Type='Dog' AND status='available' ORDER BY RAND() LIMIT 1";
        } elseif ($petType === "Cat") {
            $sql = "SELECT * FROM animal WHERE Type='Cat' AND status='available' ORDER BY RAND() LIMIT 1";
        } elseif ($petType === "Other") {
            $sql = "SELECT * FROM animal WHERE Type='Other' AND status='available' ORDER BY RAND() LIMIT 1";
        }
        // If no pet type chosen, use lifestyle/experience/age
        elseif ($activity === "active" && $home === "house") {
            $sql = "SELECT * FROM animal WHERE Size='Large' AND Type='Dog' AND status='available' ORDER BY RAND() LIMIT 1";
        } elseif ($activity === "calm" && $home === "apartment") {
            $sql = "SELECT * FROM animal WHERE (Type='Cat' OR Size='Small') AND status='available' ORDER BY RAND() LIMIT 1";
        } elseif ($experience === "first") {
            $sql = "SELECT * FROM animal WHERE Age <= 4 AND status='available' ORDER BY RAND() LIMIT 1";
        } elseif ($experience === "experienced") {
            $sql = "SELECT * FROM animal WHERE (Age >= 5 OR Size='Large') AND status='available' ORDER BY RAND() LIMIT 1";
        } elseif ($agePref === "young") {
            $sql = "SELECT * FROM animal WHERE Age <= 2 AND status='available' ORDER BY RAND() LIMIT 1";
        } elseif ($agePref === "senior") {
            $sql = "SELECT * FROM animal WHERE Age >= 8 AND status='available' ORDER BY RAND() LIMIT 1";
        }

        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $matchRow = mysqli_fetch_assoc($result);
        } else {
            $matchMsg = "😿 Sorry, no pets currently match your criteria. Please check back later!";
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
  <link href="../css/style.css" rel="stylesheet">
  <style>
    footer { position: fixed; bottom: 0; left: 0; width: 100%; padding: 1rem 0; }
    body { margin-bottom: 100px; }
    .match-img { max-height: 250px; object-fit: cover; }
  </style>
</head>
<body class="body-pic">
  <div class="container index-container mt-5">
    <h2 class="paw-card-h1 text-white text-center mb-3" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
      💘 Pet Matchmaker Quiz
    </h2>
    <p class="lead text-white text-center mb-4" style="opacity: 0.9;">
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

    <!-- Result message -->
    <?php if (!empty($matchMsg)): ?>
      <div class="alert alert-info mt-4"><?= $matchMsg ?></div>
    <?php endif; ?>

    <!-- Result card -->
    <?php if ($matchRow): ?>
      <div class="card mt-4">
        <h4 class="card-header"><?= htmlspecialchars($matchRow['Name']) ?></h4>
        <img src="../img/<?= htmlspecialchars(!empty($matchRow['ImageUrl']) ? $matchRow['ImageUrl'] : 'default-animals.png') ?>"
             alt="<?= htmlspecialchars($matchRow['Name']) ?>"
             class="img-fluid rounded mx-auto d-block mb-3 match-img"
             onerror="this.src='../img/default-animals.png'">
        <div class="card-body">
          <p class="card-text">
            <?= !empty($matchRow['Description']) ? htmlspecialchars($matchRow['Description']) : 'No description available.' ?><br>
            <strong>Breed:</strong> <?= !empty($matchRow['Breed']) ? htmlspecialchars($matchRow['Breed']) : 'Unknown' ?><br>
            <strong>Age:</strong> <?= isset($matchRow['Age']) ? htmlspecialchars($matchRow['Age']) : 'Not specified' ?> years<br>
            <strong>Type:</strong> <?= !empty($matchRow['Type']) ? htmlspecialchars($matchRow['Type']) : 'Not specified' ?><br>
            <strong>Sex:</strong> <?= !empty($matchRow['Sex']) ? htmlspecialchars($matchRow['Sex']) : 'Not specified' ?><br>
            <strong>Color:</strong> <?= !empty($matchRow['Color']) ? htmlspecialchars($matchRow['Color']) : 'Not specified' ?><br>
            <strong>Size:</strong> <?= !empty($matchRow['Size']) ? htmlspecialchars($matchRow['Size']) : 'Not specified' ?>
          </p>
          <a href="details.php?id=<?= intval($matchRow['ID']) ?>" class="btn paw-card-btn">Learn More</a>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Footer -->
  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
