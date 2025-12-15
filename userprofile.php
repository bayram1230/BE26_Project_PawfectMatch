<?php
session_start();

require_once "components/db_connect.php";
require_once "components/profile_pic.php";



if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: php/login/login.php?restricted=true");
    exit;
}


if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
    exit;
}

$username = $_SESSION["user"];

$sql = "SELECT * FROM Users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile - <?= htmlspecialchars($row["Name"]) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f8;
        }
        .profile-card {
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            background: #9affb4;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
        }
        .profile-btn {
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>

<body class="body-pic">

<?php include_once "navbar-user.php"; ?>

<div class="container my-5">

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8">

            <div class="card profile-card p-4 text-center">

                
                <div class="mb-3 mt-4">
                    <img
                        src="img/<?= htmlspecialchars($row["Img"]) ?>"
                        alt="profile picture"
                        class="profile-img"
                        onerror="this.src='img/default-users.png'"
                    >
                </div>

                
                <h3 class="fw-bold mb-3">
                    <?= htmlspecialchars($row["Username"]) ?>
                </h3> <br> 
                <hr class="border border-dark border-1 opacity-100">
                

                
                <div class="text-start">
                    <p class="mb-2">
                        <strong>Full Name:</strong><br>
                        <?= htmlspecialchars($row["Name"]) ?>
                    </p> <br>

                    <p class="mb-3">
                        <strong>Email:</strong><br>
                        <?= htmlspecialchars($row["Email"]) ?>
                    </p>
                </div> <br>

               
                <a href="update_profile.php"
                   class="btn btn-dark w-25 profile-btn mt-2">
                    Edit Profile
                </a>

            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>