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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - <?= $row["Name"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link href="css/style.css" rel="stylesheet">
</head>
<body>


<?php
include_once "navbar-user.php";
?> 

<div class="container my-5">

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-body text-center p-4">

                   
                    <div class="text-center mb-3">
                <img src="img/<?= htmlspecialchars($row["Img"]) ?>"
                    class="rounded border"
                    alt="profile picture"
                    style="width:150px; height:150px; object-fit:cover;">
                </div>

                    
                    <h3 class="fw-bold mb-1">
                        <?= htmlspecialchars($row["Username"]) ?>
                    </h3>

                    <div class="text-start px-3">
                        <p class="mb-2">
                            <strong>Full Name:</strong>
                            <?= htmlspecialchars($row["Name"]) ?>
                        </p>
                    </div>

                    <div class="text-start px-3">
                        <p class="mb-2">
                            <strong>Email:</strong>
                            <?= htmlspecialchars($row["Email"]) ?>
                        </p>
                    </div>
                      

                    
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <a href="update_profile.php" class="btn btn-success px-4">
                            Edit Profile
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
