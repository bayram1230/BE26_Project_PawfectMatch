<?php
// require_once '../functions/db_connect.php';  // Connect to database
// require_once "../functions/get_profile.php";

// $id = $_GET['id']; 
// $sql = "SELECT * FROM pets WHERE id = $id";
// $result = mysqli_query($conn, $sql);
// $layout = ""; // Dont forget to insert the $layout variable in the body of html

// if(mysqli_num_rows($result) > 0){ // mysqli_num_rows($result) → counts how many rows are in the result of your query
//                                   // > 0 → checks if there is at least one row
//     $row = mysqli_fetch_assoc($result); // fetching all rows (records) from the result of SQL query and storing them in the PHP variable
//     $layout = "
//     <div class='container'>
//         <div class='card card-border'>
//             <div class='row'>
//                 <div class='col-md-8'>
//                     <div class='card-body details-body'>
//                         <h4 class='card-title mb-5'>{$row['name']}</h4>
//                         <p>{$row['short_description']}</p>
//                         <hr class='line'>
//                         <div class='table-wrap'>
//                             <img src='../{$row['picture']}' class='card-img-top card-img2 card-img320 center border-none' alt='{$row['name']}'>
//                             <table class='border-table'>
//                                 <tr><th>Breed:</th><td>{$row['breed']}</td></tr>
//                                 <tr><th>Gender:</th><td>{$row['gender']}</td></tr>
//                                 <tr><th>Age:</th><td>{$row['age']}</td></tr>
//                                 <tr><th>Location:</th><td class='table-location'>{$row['location']}</td></tr>
//                             </table>
//                             <table>
//                                 <tr><th>Vaccine:</th><td>{$row['vaccine']}</td></tr>
//                                 <tr><th>Size:</th><td>{$row['size']}</td></tr>
//                                 <tr><th>Neutered:</th><td>{$row['neutered']}</td></tr>
//                                 <tr><th>Status:</th><td>{$row['status']}</td></tr>
//                             </table>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     </div>";
// }else{

//     $layout = "<h3>No data found</h3>";

// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <div class="container">
        <!-- Navbar start-->
        <nav class="navbar navbar-expand-lg bg-success">
            <div class="container-fluid">
                <a class="navbar-brand">PetHero</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="create.php">Senior</a></li>
                        <li class="nav-item"><a class="nav-link" href="../register-login/register.php">Sign up</a></li>
                    </ul>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item dropdown d-flex align-items-center">
                            <a href="<?= getProfileLink() ?>" class="me-2">
                                <img src="<?= BASE_URL ?>img/<?= htmlspecialchars(getProfilePicture($conn)) ?>" style="width:40px" class="rounded-circle">
                            </a>
                            <a class="nav-link dropdown-toggle p-0"
                               href="#"
                               id="profileDropdown"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false"></a>
                            <ul class="dropdown-menu dropdown-menu-end text-dark" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item text-dark" href="../register-login/login.php">Login</a></li>
                                <li><a class="dropdown-item text-dark" href="../register-login/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar end -->
        <!-- Main Content Start -->
        <?= $layout; ?>
        <!-- Main Content End -->
        <!-- Footer Start -->
        <footer class="bg-success">
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-google"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
            <div class="newsletter mb-4">
                <form class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                    <label for="newsletter-email" class="form-label text-white mb-0">Sign up for our newsletter</label>
                    <input type="email" id="newsletter-email" class="form-control" placeholder="Enter your email">
                    <button type="submit" class="btn btn-outline-light">Subscribe</button>
                </form>
            </div>
            <div class="copyright">© 2025 Copyright: Bayram Karahan</div>
        </footer>
        <!-- Footer End -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
