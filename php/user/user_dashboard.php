<?php
session_start();

require_once "../../components/db_connect.php";
require_once "../functions/get_profile.php";
require_once __DIR__ . "/../functions/user_restriction.php";

requireUser();

/* Security */
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../../php/login/login.php");
    exit;
}

$username = $_SESSION['username'];
$profilePic = getProfilePicture($conn);

/* -------------------------
   DASHBOARD COUNTS
-------------------------- */

$sqlApplications = "
    SELECT COUNT(*) AS total 
    FROM adoptionrequest 
    WHERE Username = ?
";
$stmt = mysqli_prepare($conn, $sqlApplications);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$applications = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];

$sqlMessages = "
    SELECT COUNT(*) AS total 
    FROM message 
    WHERE Username = ?
";
$stmt = mysqli_prepare($conn, $sqlMessages);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$messages = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];

$layout = "
<div class='dashboard-content'>

    <h1 class='dashboard-title'>
        Welcome back, " . htmlspecialchars($username) . "
    </h1>

    <p class='dashboard-subtitle'>
        Here is a quick overview of your activity.
    </p>

    <div class='row g-4 mt-4'>
        <div class='col-md-6 col-lg-6 mx-auto'>
            <div class='card text-center p-4 shadow'>
                <h5>My Applications</h5>
                <h2 class='fw-bold'>$applications</h2>
                <a href='my_applications.php' class='btn btn-dark btn-sm mt-2'>
                    View Applications
                </a>
            </div>
        </div>
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
<style>

</style>
<body class="body-pic">

<!-- NAVBAR -->
<?php require_once "../../components/navbar.php"; ?>
<?php require_once __DIR__ . "/user_menu.php"; ?>
<?php require_once __DIR__ . "/btn.php"; ?>

<!-- MAIN CONTENT -->
<div class="container index-container">
    

    <!-- TOP BAR -->
    <div class="dashboard-topbar">
        <!-- dein bestehender topbar-inhalt -->
    </div> <!-- ✅ HIER WAR DER FEHLER -->

    <!-- WELCOME CONTENT -->
    <div class="dashboard-welcome-wrapper">
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
</body>
</html>
