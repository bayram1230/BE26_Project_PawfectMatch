<?php
require_once "../functions/user_restriction.php";
requireAdmin();

require_once "../../components/db_connect.php";
require_once "../../components/navbar.php";

/* =========================
   USER REPORTS
   ========================= */
$userTotal = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
)['total'];

$userAdmins = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE Role = 'admin'")
)['total'];

$userShelters = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE Role = 'shelter'")
)['total'];

$userUsers = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE Role = 'user'")
)['total'];

/* =========================
   PET REPORTS
   ========================= */
$petTotal = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM animal")
)['total'];

/* optional: falls status existiert */
$petPending = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM animal WHERE status = 'pending'")
)['total'] ?? 0;

/* =========================
   APPLICATION REPORTS
   ========================= */
$appTotal = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM applications")
)['total'];

$appPending = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM applications WHERE status = 'pending'")
)['total'];

$appApproved = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM applications WHERE status = 'approved'")
)['total'];

$appRejected = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM applications WHERE status = 'rejected'")
)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="body-pic">

<div class="container index-container">

    <div class="d-flex justify-content-end mb-3">
        <button
            class="btn operations-btn"
            data-bs-toggle="offcanvas"
            data-bs-target="#adminOffcanvas"
        >
            ☰ Operations
        </button>
    </div>

    <h1 class="paw-card-h1">System Reports</h1>

    <div class="row g-4 mt-4">

        <!-- USERS -->
        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Total Users</h6>
                <h2><?= $userTotal ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Admins</h6>
                <h2><?= $userAdmins ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Shelters</h6>
                <h2><?= $userShelters ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Users</h6>
                <h2><?= $userUsers ?></h2>
            </div>
        </div>

        <!-- PETS -->
        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Total Pets</h6>
                <h2><?= $petTotal ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Pending Pets</h6>
                <h2><?= $petPending ?></h2>
            </div>
        </div>

        <!-- APPLICATIONS -->
        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Total Applications</h6>
                <h2><?= $appTotal ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Pending</h6>
                <h2><?= $appPending ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Approved</h6>
                <h2><?= $appApproved ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h6>Rejected</h6>
                <h2><?= $appRejected ?></h2>
            </div>
        </div>

    </div>
</div>

<!-- OFFCANVAS -->
<?php require_once "admin_offcanvas.php"; ?>

<footer class="mt-auto">
    <div class="copyright text-primary-emphasis mb-4 fw-bold">
        © 2025 Copyright: Group 1
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
