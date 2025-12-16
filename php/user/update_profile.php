<?php
session_start();

require_once "../../components/db_connect.php";
require_once "../../components/function.php";
require_once "../../components/fileupload.php";
require_once "../functions/get_profile.php";




if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login/login.php?restricted=true");
    exit;
}

$username = $_SESSION['username'];


$sql = "SELECT * FROM Users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST["update"])) {

    $name  = cleanInput($_POST["name"]);
    $email = cleanInput($_POST["email"]);

   
    if (empty($name)) {
        $error = "Name cannot be empty.";
    } elseif (!preg_match("/^[a-zA-Z0-9\s]+$/", $name)) {
        $error = "Only letters, numbers and spaces allowed!";
    }

    if (empty($email)) {
        $error = "Email cannot be empty.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }

    if (!isset($error)) {

        
        if ($_FILES["picture"]["error"] == 4) {

            
            $sqlUpdate = "
                UPDATE Users 
                SET Name = '$name', Email = '$email'
                WHERE Username = '$username'
            ";

        } else {

            
            $picture = fileUpload($_FILES["picture"], "user");

            
            if ($row["Img"] != "default-user.png") {
                unlink("img/" . $row["Img"]);
            }

            $sqlUpdate = "
                UPDATE Users 
                SET Name = '$name', Email = '$email', Img = '{$picture[0]}'
                WHERE Username = '$username'
            ";
        }

        if (mysqli_query($conn, $sqlUpdate)) {
            header("Location: userprofile.php");
            exit;
        } else {
            $error = "Something went wrong.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
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

                
               

                <h3 class="fw-bold mb-3">
                    Edit Profile
                </h3>

                <hr class="border border-dark border-1 opacity-100 mb-4">

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                
                <form method="post" enctype="multipart/form-data" class="text-start">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            value="<?= htmlspecialchars($row["Name"]) ?>"
                        >
                    </div>
                        <br>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            value="<?= htmlspecialchars($row["Email"]) ?>"
                        >
                    </div>
                    <br>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Profile Picture</label>
                        <input
                            type="file"
                            class="form-control"
                            name="picture"
                        >
                    </div>
                    <br>

                    
                    <div class="d-flex justify-content-center gap-3">
                        <button
                            type="submit"
                            name="update"
                            class="btn btn-dark w-25 profile-btn"
                        >
                            Update
                        </button>

                        <a
                            href="userprofile.php"
                            class="btn btn-secondary w-25 profile-btn"
                        >
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
