
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

 
require_once "../../components/db_connect.php";
require_once "../../components/navbar.php";
require_once "../functions/get_profile.php";
require_once  "../functions/user_restriction.php";
 
requireShelter(); // nur User darf rein
 
/* Security: only logged-in users */
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'shelter') {
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
            Use the menu to post adoptable pets, manage adoption applications, and update your shelter information.
        </p>
    </div>
 
</div>
";
 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shelter Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    >
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="body-pic">
 
    <!-- MAIN CONTENT -->
    <div class="container index-container">
        <div class="d-flex justify-content-end gap-2 mb-3">
            <a href="../crud/create.php" class="btn add-new-pet-btn">
                Add new pet 🐾
            </a>
            <button
                class="btn operations-btn"
                data-bs-toggle="offcanvas"
                data-bs-target="#adminOffcanvas"
            >
                ☰ Operations
            </button>
        </div>
        <h1 class="paw-card-h1">Shelter Dashboard</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?= $layout ?>
        </div>
    </div>
    <!-- OFFCANVAS -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="adminOffcanvas">
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

            <!-- DASHBOARD -->
            <li class="dropdown">
                <a
                    href="#"
                    class="custom-nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                >
                    Dashboard
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="shelter_dashboard.php" class="dropdown-item">Overview</a></li>
                </ul>
            </li>

            <hr>

            <!-- PET LISTINGS -->
            <li class="dropdown">
                <a
                    href="#"
                    class="custom-nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                >
                    Pet Listings
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="pets.php" class="dropdown-item">All Pets</a></li>
                    <li><a href="create.php" class="dropdown-item">Add New Pet</a></li>
                </ul>
            </li>

            <hr>

            <!-- APPLICATIONS -->
            <li class="dropdown">
                <a
                    href="#"
                    class="custom-nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                >
                    Applications
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="shelter_applications.php" class="dropdown-item">Review Applications</a></li>
                </ul>
            </li>

            <hr>

            <!-- MESSAGES -->
            <li class="dropdown">
                <a
                    href="#"
                    class="custom-nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                >
                    Messages
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="shelter_messages.php" class="dropdown-item">Inbox</a></li>
                </ul>
            </li>

            <hr>

            <!-- RESOURCES -->
            <li class="dropdown">
                <a
                    href="#"
                    class="custom-nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                >
                    Resources
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="shelter_resources.php" class="dropdown-item">Manage Resources</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>

    <!-- FOOTER -->
    <footer class="mt-auto">
        <div class="copyright text-primary-emphasis mb-4 fw-bold">
            © 2025 Copyright: Group 1
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
