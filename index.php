<?php
session_start();

require_once "php/functions/db_connect.php";
require_once "php/functions/get_profile.php";

// load profile picture from function
if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    $profilePic = getProfilePicture($conn);
} else {
    $profilePic = "default-users.png";
}

// DB
$sql = "SELECT * FROM Animal";
$result = mysqli_query($conn, $sql);

$layout = "";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $image = "img/no-image.png";
        $layout .= "
            <h1 class='custom-card-h1'>Current list of available pets</h1>
            <div class='card custom-card card-index'>
                <img src='img/" . htmlspecialchars($row['img']) . "' 
                     class='custom-card-img' 
                     alt='" . htmlspecialchars($row['Name']) . "'>
                <div class='card-body custom-card-body'>
                    <h5 class='card-title'>" . htmlspecialchars($row['Name']) . "</h5>
                    <hr class='card-hr'>
                    <h4 class='card-text'>Breed: " . htmlspecialchars($row['Type']) . "</h4>
                </div>
                <div class='d-flex justify-content-center'>
                    <a href='php/crud/details.php?id={$row['ID']}' class='btn card-btn'>
                        More Details
                    </a>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand-lg custom-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo.png" alt="brand" style="width: 50px; height: 40px">
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
                        <a class="nav-link active" href="index.php">Home</a>
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
                                <a class="dropdown-item" href="php/crud/create.php">Add new animal</a>
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

                        <img src="img/<?= htmlspecialchars($profilePic) ?>" class="rounded-circle">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           id="profileDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"></a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end text-light mb-4"
                            aria-labelledby="profileDropdown">

                            <?php if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])): ?>
                                <li><a class="dropdown-item" href="php/register-login/login.php">Login</a></li>
                                <li><a class="dropdown-item" href="php/register-login/register.php">Sign Up</a></li>

                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?= getProfileLink() ?>">Dashboard</a></li>
                                <li><a class="dropdown-item" href="php/register-login/logout.php">Logout</a></li>
                            <?php endif; ?>

                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container index-container">
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
