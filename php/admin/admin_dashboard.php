<?php
require_once "../functions/user_restriction.php";
requireAdmin();

require_once "../../components/db_connect.php";
require_once "../functions/get_profile.php";
require_once "../../components/navbar.php";

/* Username */
$username = htmlspecialchars($_SESSION['username']);

/* -----------------------------
   DASHBOARD KPIs (REAL DATA)
------------------------------ */

// Total Users
$totalUsers = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
)['total'];

// Total Shelters
$totalShelters = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'shelter'")
)['total'];

// Total Pets
$totalPets = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM animal")
)['total'];

// Open Adoption Requests
$openRequests = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM adoptionrequest")
)['total'];

// Successful Adoptions
$successfulAdoptions = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM adoptionhistory WHERE Status = 'Approved'"
    )
)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="body-pic">

<div class="container index-container">

    <!-- ================= KPI STATS ================= -->
    <div class="dashboard-stats-wrapper mb-4">

        <div class="dashboard-stat">
            <h4>Total Users</h4>
            <p><?= $totalUsers ?></p>
        </div>

        <div class="dashboard-stat">
            <h4>Total Shelters</h4>
            <p><?= $totalShelters ?></p>
        </div>

        <div class="dashboard-stat">
            <h4>Total Pets</h4>
            <p><?= $totalPets ?></p>
        </div>

        <div class="dashboard-stat">
            <h4>Adoption Requests</h4>
            <p><?= $openRequests ?></p>
        </div>

        <div class="dashboard-stat">
            <h4>Successful Adoptions</h4>
            <p><?= $successfulAdoptions ?></p>
        </div>

    </div>

    <!-- ================= OPERATIONS BUTTON ================= -->
    <div class="admin-welcome">
        <button
            class="btn operations-btn"
            data-bs-toggle="offcanvas"
            data-bs-target="#adminOffcanvas"
        >
            ☰ Operations
        </button>
    </div>

    <!-- ================= HERO GRID (PERFEKT ZENTRIERT) ================= -->
<div class="admin-hero">
   
    <div class="admin-hero-left">
        <div class="admin-hero-box">
            <h1 class="admin-hero-title">Admin<br>Dashboard</h1>
        </div>
    </div>

    <div class="admin-hero-center">
        <img src="../../img/logo.png" class="admin-dashboard--img" alt="Pawfect Match">
    </div>

    <div class="admin-hero-right">
        <div class="admin-hero-box">
            <h1 class="admin-hero-title">
                Welcome back,<br><?= $username ?>
            </h1>
        </div>
    </div>

</div>



</div>

<!-- ================= OFFCANVAS ================= -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="adminOffcanvas">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body text-center">
        <img
            src="../../img/navbar-logo.png"
            alt="logo"
            style="width:300px"
            class="mb-4"
        >

        <ul class="list-unstyled admin-ul">

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Dashboard
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="admin_dashboard.php" class="dropdown-item">Overview</a></li>
                </ul>
            </li>

            <hr>

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    User Management
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="admin_users.php" class="dropdown-item">All Users</a></li>
                    <li><a href="admin_shelters.php" class="dropdown-item">Shelters</a></li>
                </ul>
            </li>

            <hr>

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Pet Management
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="admin_pending_pets.php" class="dropdown-item">Pending Approval</a></li>
                </ul>
            </li>

            <hr>

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Applications
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="../shelter/applications.php" class="dropdown-item">All Applications</a></li>
                </ul>
            </li>

            <hr>

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Reports & History
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="admin_reports.php" class="dropdown-item">Analytics</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>

<footer class="mt-auto">
    <div class="copyright text-primary-emphasis mb-4 fw-bold">
        © 2025 Copyright: Group 1
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
