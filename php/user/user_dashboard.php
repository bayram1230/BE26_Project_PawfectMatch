<?php
session_start();

require_once "../../components/db_connect.php";
require_once "../functions/get_profile.php";

/* Security: only logged-in users */
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../../php/login/login.php");
    exit;
}

/* Profile picture */
$profilePic = getProfilePicture($conn);

/* Username (VORHER, nicht im String!) */
$userName = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');


/* Load pets (READ ONLY) */
$sql = "SELECT * FROM animal";
$result = mysqli_query($conn, $sql);

/* DASHBOARD CONTENT (EINMAL!) */
$layout = "
<div class='dashboard-content'>

    <h1 class='dashboard-title'>
        Welcome back, $userName 👋
    </h1>

    <p class='dashboard-subtitle'>
        What would you like to do today?
    </p>

    <div class='dashboard-info-box'>
        <p>
            Use the menu to browse pets, manage your applications,
            read messages or update your profile.
        </p>
    </div>

</div>
";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="body-pic">

<!-- NAVBAR -->
<?php require_once "../../components/navbar.php"; ?>

<!-- MAIN CONTENT -->
<div class="container index-container">

    <!-- TOP BAR -->
    <div class="dashboard-topbar">
        <h1 class="paw-card-h1">User Dashboard</h1>

        <div class="dashboard-logo">
            <img src="../../img/logo.png" alt="Pawfect Match Logo">
        </div>

        <button
            class="btn user-menu-btn"
            data-bs-toggle="offcanvas"
            data-bs-target="#userOffcanvas"
        >
            ☰ Menu
        </button>
    </div>

    <!-- WELCOME CONTENT -->
    <div class="dashboard-welcome-wrapper">
        <?= $layout ?>
    </div>

</div>


<!-- OFFCANVAS USER -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="userOffcanvas">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body text-center">
        <img
            src="../../img/navbar-logo.png"
            alt="logo"
            style="width: 300px;"
            class="mb-4"
        >

        <ul class="list-unstyled admin-ul">

            <li><a href="user_dashboard.php" class="custom-nav-link">Dashboard</a></li>
            <hr>

           <li><a href="../../pets.php" class="custom-nav-link">Search Pets</a></li>

            <hr>

            <li><a href="my_applications.php" class="custom-nav-link">My Applications</a></li>
            <hr>

            <li><a href="user_messages.php" class="custom-nav-link">Messages</a></li>
            <hr>

            <li><a href="userprofile.php" class="custom-nav-link">Profile / Settings</a></li>

        </ul>
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
