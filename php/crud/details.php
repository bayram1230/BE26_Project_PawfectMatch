<?php

require_once __DIR__ . "/../../components/db_connect.php";
require_once __DIR__ . "/../functions/get_profile.php";

// load profile picture from function
if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    $profilePic = getProfilePicture($conn);
} else {
    $profilePic = "default-users.png";
}

// Check if ID exists in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<h3>No ID provided.</h3>");
}

$id = intval($_GET['id']); // Secure value

// Use correct table name + correct column names based on your SQL dump
$sql = "SELECT * FROM animal WHERE ID = $id";
$result = mysqli_query($conn, $sql);

$layout = "";

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

// Build layout
$layout = "
    <div class='card details-card text-center'>
        <div class='card-body details-card-body'>
            <img src='../../img/default-animals.png'
                 class='custom-card-img'
                 alt=\"{$row['Name']}\">
            <div class='details-right'>
                <h2 class='card-title text-center'>{$row['Name']}</h2>
                <div class='description-wrapper'>
                    <p class='card-text'>{$row['Description']}</p>
                </div>
                <div class='details-info-row'>
                    <table class='details-table'>
                        <tr><th>Type:</th><td>{$row['Type']}</td></tr>
                        <tr><th>Breed:</th><td>{$row['Breed']}</td></tr>
                        <tr><th>Sex:</th><td>{$row['Sex']}</td></tr>
                        <tr><th>Age:</th><td>{$row['Age']}</td></tr>
                        <tr><th>Color:</th><td>{$row['Color']}</td></tr>
                        <tr><th>Size:</th><td>{$row['Size']}</td></tr>
                    </table>
                    <button class='inline-btn'>Take Me Home 🐾</button>
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
    <title>Exam 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand-lg custom-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php">
                <img src="../../img/logo-navbar.png" alt="logo" style="width: 60px; height: 40px">
            </a>
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDarkDropdown"
                    aria-controls="navbarNavDarkDropdown"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav mx-auto navbar-links">
                    <li class="nav-item">
                        <a class="nav-link active" href="/index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">
                            Animals
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item" href="/php/crud/create.php">
                                    Add new animal
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Contact us</a>
                    </li>
                </ul>
                <!-- Profile Dropdown -->
                <ul class="navbar-nav ms-auto navbar-profile">
                    <li class="nav-item dropdown profile-dropdown">
                        <img src="../../img/<?= htmlspecialchars($profilePic) ?>"
                             class="rounded-circle"
                             style="width:35px">
                        <a class="nav-link dropdown-toggle text-light"
                           href="#"
                           id="profileDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"></a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end text-light mb-4"
                            aria-labelledby="profileDropdown">

                            <?php if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])): ?>

                                <li>
                                    <a class="dropdown-item" href="/php/login/login.php">Login</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/php/login/register.php">Sign Up</a>
                                </li>

                            <?php else: ?>

                                <li>
                                    <a class="dropdown-item" href="<?= getProfileLink() ?>">Dashboard</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/php/login/logout.php">Logout</a>
                                </li>

                            <?php endif; ?>

                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container details-container">
        <div class="logo-wrapper">
            <img class="index-logo" src="../../img/logo.png" alt="logo">
        </div>
        <h1 class='custom-card-h1'>Details</h1>
        <div class="row">
            <?= $layout ?>
        </div>
    </div>
        <!-- Footer -->
    <footer class="mt-auto py-4">
        <div class="social-icons text-center mb-3">
            <a href="#"><i class="fab fa-facebook text-white"></i></a>
            <a href="#"><i class="fab fa-twitter text-white"></i></a>
            <a href="#"><i class="fab fa-google text-white"></i></a>
            <a href="#"><i class="fab fa-instagram text-white"></i></a>
            <a href="#"><i class="fab fa-linkedin-in text-white"></i></a>
            <a href="#"><i class="fab fa-x-twitter text-white"></i></a>
        </div>
        <div class="newsletter text-center mb-4">
            <form method="get" 
                  class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                <label for="newsletter-email" class="form-label text-white mb-0">
                    Sign up for our newsletter
                </label>
                <input type="email"
                       id="newsletter-email"
                       class="form-control newsletter-sign-up-box"
                       placeholder="Enter your email">
                <button type="submit" class="btn subscribe">Subscribe</button>
            </form>
        </div>
        <div class="copyright">
            © 2025 Copyright: Group 1
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
