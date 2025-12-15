<?php

$profilePic = $profilePic ?? "default-users.png";
?>

<nav class="navbar navbar-dark navbar-expand-lg custom-navbar sticky-top">
    <div class="container-fluid">

        
        <a class="navbar-brand" href="home.php">
            <img src="img/logo-navbar.png" alt="brand" style="width: 50px; height: 40px">
        </a>

       
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarUser"
                aria-controls="navbarUser"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        
        <div class="collapse navbar-collapse" id="navbarUser">

            
            <ul class="navbar-nav mx-auto navbar-links">
                <li class="nav-item">
                    <a class="nav-link active" href="home.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pets.php">Search Pets</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="my_applications.php">My Applications</a>
                </li>
            </ul>

            
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">

                    
                    <a class="nav-link dropdown-toggle d-flex align-items-center"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <img src="img/<?= htmlspecialchars($profilePic) ?>"
                             alt="profile"
                             class="rounded-circle"
                             style="width: 35px; height: 35px; object-fit: cover;">
                    </a>

                    
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="userprofile.php">
                                My Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="logout.php">
                                Logout
                            </a>
                        </li>
                    </ul>

                </li>
            </ul>

        </div>
    </div>
</nav>
