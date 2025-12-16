<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? 'guest';
$profilePic = $profilePic ?? 'default-users.png';
?>

<nav class="navbar navbar-expand-lg custom-navbar sticky-top">
    <div class="container-fluid">

        <!-- LOGO -->
        <a class="navbar-brand" href="<?= BASE_URL ?>index.php">
            <img src="<?= BASE_URL ?>img/navbar-logo.png" alt="logo" class="navbar-logo">
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavDarkDropdown"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">

            <!-- CENTER -->
            <ul class="navbar-nav mx-auto navbar-links">

                <!-- HOME (ALLE) -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>index.php">Home</a>
                </li>

                <!-- PETS (guest, user, admin) -->
                <?php if ($role !== 'shelter'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Pets
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>fostered_pets.php">Fostered Pets</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>pets.php">Search Pets</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>adopted_pets.php">Adopted Pets</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>pet_of_week.php">Pet of the Week</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- INFO (ALLE) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Info
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>resources.php">Resource Library</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>stories.php">Adoption Stories</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>volunteer.php">Volunteer Opportunities</a></li>

                        <!-- USER + ADMIN -->
                        <?php if ($role === 'user' || $role === 'admin'): ?>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>my_applications.php">My Applications</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <!-- ADMIN ENTRY (nur Einstieg, keine CRUDs) -->
                <?php if ($role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>php/admin/admin_dashboard.php">
                        Admin
                    </a>
                </li>
                <?php endif; ?>

                <!-- CONTACT (ALLE) -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>contact.php">Contact us</a>
                </li>

            </ul>

            <!-- PROFILE -->
            <ul class="navbar-nav ms-auto navbar-profile">
                <li class="nav-item dropdown profile-dropdown">

                    <img
                        src="<?= BASE_URL ?>img/<?= htmlspecialchars($profilePic) ?>"
                        class="rounded-circle"
                        alt="Profile picture"
                    >

                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"></a>

                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <?php if ($role === 'guest'): ?>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>php/login/login.php">Login</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>php/login/register.php">Sign Up</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="<?= getProfileLink() ?>">Dashboard</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>php/login/logout.php">Logout</a></li>
                        <?php endif; ?>
                    </ul>

                </li>
            </ul>

        </div>
    </div>
</nav>
