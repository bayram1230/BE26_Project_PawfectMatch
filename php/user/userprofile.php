<?php
session_start();
require_once "../../components/db_connect.php";
require_once "../functions/get_profile.php";
require_once __DIR__ . "/../functions/user_restriction.php";

requireUser(); // nur User darf rein


/* nur User darf rein */
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {  
    header("Location: ../login/login.php?restricted=true");
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM Users WHERE Username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile - <?= htmlspecialchars($row["Name"]) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">


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

<?php require_once "../../components/navbar.php"; ?>


<div class="container my-5">

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8">

            <div class="card profile-card p-4 text-center">

                
                <div class="mb-3 mt-4">
                    <img
                src="../../img/<?= htmlspecialchars($row['Img'] ?? 'default-users.png') ?>"
                class="profile-img"
                onerror="this.src='../../img/default-users.png'"
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