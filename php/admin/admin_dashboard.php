<?php
session_start();

// require_once "../functions/user_restriction.php";
// requireAdmin();

require_once "../../components/db_connect.php";
require_once "../functions/get_profile.php";

/* Profile picture */
if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    $profilePic = getProfilePicture($conn);
} else {
    $profilePic = "default-users.png";
}

/* Load pets */
$sql = "SELECT * FROM animal";
$result = mysqli_query($conn, $sql);

$layout = "";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        if (!empty($row['img'])) {
            $imgPath = (strpos($row['img'], 'http') === 0)
                ? $row['img']
                : "../../img/" . $row['img'];
        } else {
            $imgPath = "../../img/default-animals.png";
        }

        $layout .= "
        <div class='col'>
            <div class='card paw-card paw-card--admin'>
                <div class='paw-card-inner'>
                    <div class='paw-card-content'>
                        <img
                            src='" . htmlspecialchars($imgPath) . "'
                            class='paw-card-img'
                            alt='" . htmlspecialchars($row['Name']) . "'
                        >
                        <div class='paw-card-title-wrapper'>
                            <h5 class='paw-card-title'>" . htmlspecialchars($row['Name']) . "</h5>
                            <hr class='index-card-hr'>
                            <div class='d-flex justify-content-center gap-2 mt-3'>
                                <a
                                    href='../crud/update.php?id={$row['ID']}'
                                    class='btn update-btn px-3'
                                >
                                    UPDATE
                                </a>
                                <form
                                    action='../crud/delete.php'
                                    method='POST'
                                    onsubmit=\"return confirm('Are you sure you want to delete this pet?');\"
                                >
                                    <input type='hidden' name='id' value='{$row['ID']}'>
                                    <button type='submit' class='btn delete-btn px-3'>
                                        <i class='fa-solid fa-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
} else {
    $layout = "<h3 class='text-center'>No animals found</h3>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg custom-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php">
                <img
                    src="/img/navbar-logo.png"
                    alt="logo"
                    class="navbar-logo"
                >
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavDarkDropdown"
                aria-controls="navbarNavDarkDropdown"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav mx-auto navbar-links">
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto navbar-profile">
                    <li class="nav-item dropdown profile-dropdown">
                        <img
                            src="/img/<?= htmlspecialchars($profilePic) ?>"
                            class="rounded-circle"
                            alt="Profile picture"
                        >
                        <a
                            class="nav-link dropdown-toggle text-light"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        ></a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">

                            <?php if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])): ?>
                                <li><a class="dropdown-item" href="/php/login/login.php">Login</a></li>
                                <li><a class="dropdown-item" href="/php/login/register.php">Sign Up</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?= getProfileLink() ?>">Dashboard</a></li>
                                <li><a class="dropdown-item" href="/php/login/logout.php">Logout</a></li>
                            <?php endif; ?>

                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
        <h1 class="paw-card-h1">Admin Dashboard</h1>
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
                <li><a href="admin_all_pets.php" class="custom-nav-link">All pets</a></li>
                <hr>
                <li><a href="admin_history.php" class="custom-nav-link">History</a></li>
            </ul>
        </div>
    </div>
    <!-- FOOTER -->
    <footer class="mt-auto">
        <div class="copyright text-center">
            © 2025 Copyright: Group 1
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
