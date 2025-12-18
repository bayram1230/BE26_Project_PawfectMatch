<?php

require_once "../../components/db_connect.php";
require_once "../functions/get_profile.php";
require_once "../../components/navbar.php";
require_once "../functions/user_restriction.php";
requireAdmin();

/* Admin check */
if (
    !isset($_SESSION['user_id'], $_SESSION['role']) ||
    $_SESSION['role'] !== 'admin'
) {
    die("Access denied.");
}

/* Profile picture */
if (isset($_SESSION['username'])) {
    $profilePic = getProfilePicture($conn);
} else {
    $profilePic = "default-users.png";
}

/* =========================
   FILTER & SEARCH
   ========================= */
$filterRole = $_GET['role']   ?? 'all';
$search     = $_GET['search'] ?? '';

$sql = "SELECT id, Username, Email, Role FROM users WHERE 1=1";
$params = [];
$types  = "";

if ($filterRole !== 'all') {
    $sql .= " AND Role = ?";
    $params[] = $filterRole;
    $types .= "s";
}

if (!empty($search)) {
    $sql .= " AND Username LIKE ?";
    $params[] = "%" . $search . "%";
    $types .= "s";
}

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="body-pic">

<!-- MAIN CONTENT -->
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

    <h1 class="paw-card-h1">User Management</h1>

    <!-- FILTER & SEARCH -->
     <div class="paw-card p-5">
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="all" <?= $filterRole === 'all' ? 'selected' : '' ?>>All</option>
                <option value="user" <?= $filterRole === 'user' ? 'selected' : '' ?>>Users</option>
                <option value="shelter" <?= $filterRole === 'shelter' ? 'selected' : '' ?>>Shelters</option>
            </select>
        </div>

        <div class="col-md-5">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search by username..."
                value="<?= htmlspecialchars($search) ?>"
            >
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>

        <div class="col-md-2">
            <a href="admin_users.php" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

    <!-- USER TABLE -->
    <div class="table-responsive mt-4">
        <table class="table  table-striped align-middle  p-5">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Username']) ?></td>
                        <td><?= htmlspecialchars($row['Email']) ?></td>
                        <td><?= htmlspecialchars($row['Role']) ?></td>
                        <td class="text-center">
                            <?php if ($row['id'] !== $_SESSION['user_id']): ?>
                                <form
                                    action="delete_user.php"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');"
                                    class="d-inline"
                                >
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">You</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No users found
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<!-- OFFCANVAS (IDENTISCH ZUM ADMIN DASHBOARD) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="adminOffcanvas">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body text-center">
        <img src="../../img/navbar-logo.png" alt="logo" style="width: 300px;" class="mb-4">

        <ul class="list-unstyled admin-ul">

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Dashboard</a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="admin_dashboard.php" class="dropdown-item">Overview</a></li>
                </ul>
            </li>

            <hr>

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">User Management</a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="admin_users.php" class="dropdown-item">All Users</a></li>
                    <li><a href="admin_shelters.php" class="dropdown-item">Shelters</a></li>
                </ul>
            </li>

            <hr>

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Pet Management</a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="admin_dashboard.php" class="dropdown-item">All Pets</a></li>
                    <li><a href="admin_pending_pets.php" class="dropdown-item">Pending Approval</a></li>
                </ul>
            </li>

            <hr>

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Applications</a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="admin_applications.php" class="dropdown-item">All Applications</a></li>
                </ul>
            </li>

            <hr>

            <li class="dropdown">
                <a class="custom-nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Reports & History</a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a href="admin_history.php" class="dropdown-item">System History</a></li>
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
