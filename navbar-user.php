<?php


require_once "components/db_connect.php";
require_once "php/functions/get_profile.php";


if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    $profilePic = getProfilePicture($conn);
} else {
    $profilePic = "default-users.png";
}
?>

<nav class="navbar navbar-expand-lg custom-navbar sticky-top">
    <div class="container-fluid">

        
        <a class="navbar-brand" href="index.php">
            <img src="img/navbar-logo.png" alt="logo" class="navbar-logo">
        </a>

        
        <button
            class="navbar-toggler"
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
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Pets
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="fostered_pets.php">Fostered Pets</a></li>
                        <li><a class="dropdown-item" href="pets.php">Search Pets</a></li>
                        <li><a class="dropdown-item" href="adopted_pets.php">Adopted Pets</a></li>
                        <li><a class="dropdown-item" href="pet_of_week.php">Pet of the Week</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Info
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="resources.php">Resource Library</a></li>
                        <li><a class="dropdown-item" href="stories.php">Adoption Stories</a></li>
                        <li><a class="dropdown-item" href="volunteer.php">Volunteer Opportunities</a></li>
                        <li><a class="dropdown-item" href="my_applications.php">My Applications</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link">Contact us</a>
                </li>
            </ul>

            
            <ul class="navbar-nav ms-auto navbar-profile">
                <li class="nav-item dropdown profile-dropdown">

                    <img src="img/<?= htmlspecialchars($profilePic) ?>"
                         class="rounded-circle"
                         style="width:35px; height:35px; object-fit:cover;
                         "onerror="this.src='img/default-users.png'">

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
                                <a class="dropdown-item" href="php/login/login.php">Login</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="php/login/register.php">Sign Up</a>
                            </li>

                        <?php else: ?>

                            
                            <li>
                                <a class="dropdown-item" href="userprofile.php">My Profile</a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="<?= getProfileLink() ?>">Dashboard</a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </li>

                        <?php endif; ?>

                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
