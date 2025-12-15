<?php
require_once "../../components/db_connect.php";
require_once "../../components/function.php";
require_once "../../components/fileupload.php";


$error = false;

if (isset($_POST["register"])) {

    $username = cleanInput($_POST["username"]);
    $name     = cleanInput($_POST["name"]);
    $email    = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);

    $picture = fileUpload($_FILES["picture"]);
    $img = $picture[0];

   
    if (empty($username)) {
        $error = true;
        $usernameError = "Username is mandatory";
    } elseif (strlen($username) < 3 || strlen($username) > 20) {
        $error = true;
        $usernameError = "Username should be between 3 and 20 characters";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $error = true;
        $usernameError = "Only letters, numbers and underscore are allowed";
    } else {

        $sql = "SELECT Username FROM Users WHERE Username = '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error = true;
            $usernameError = "This username is already taken";
        }
    }


   
    if (empty($name)) {
        $error = true;
        $nameError = "Name is mandatory";
    } elseif (strlen($name) < 2 || strlen($name) > 20) {
        $error = true;
        $nameError = "Name should be between 2 and 20 characters";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $error = true;
        $nameError = "Only letters and spaces are allowed";
    }

    
    if (empty($email)) {
        $error = true;
        $emailError = "Email is mandatory";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please use a valid email format";
    } else {
        $sql = "SELECT Email FROM Users WHERE Email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error = true;
            $emailError = "This email is already registered";
        }
    }

   
    if (empty($password)) {
        $error = true;
        $passwordError = "Password is mandatory";
    } elseif (strlen($password) < 6 || strlen($password) > 30) {
        $error = true;
        $passwordError = "Password must be between 6 and 30 characters";
    }

   
    if (!$error) {

        $password = hash("sha256", $password);

        $sql = "
            INSERT INTO Users (Username, Password, Name, Email, Role, Img)
            VALUES ('$username', '$password', '$name', '$email', 'user', '{$img}')
        ";

        if (mysqli_query($conn, $sql)) {
            $success = "<div class='alert alert-success'>Registration successful!</div>";
        } else {
            $success = "<div class='alert alert-danger'>Something went wrong.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f8;
        }
        .register-card {
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            background: #9affb4;
        }
        .register-card input {
            border-radius: 8px;
        }
        .register-btn {
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container my-5">

   
    <h1 class="text-center mb-4 fw-bold">
    <img 
        src="../../img/logo-black.png" 
        alt="Pawfect Match Logo"
        style="max-width: 220px; height: auto;"
    >
</h1>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card register-card p-4">

                <?= $success ?? "" ?>

                <form method="post" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label">Username *</label>
                        <input type="text" class="form-control" name="username" value="<?= $username ?? "" ?>">
                        <small class="text-danger"><?= $usernameError ?? "" ?></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" name="name" value="<?= $name ?? "" ?>">
                        <small class="text-danger"><?= $nameError ?? "" ?></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" value="<?= $email ?? "" ?>">
                        <small class="text-danger"><?= $emailError ?? "" ?></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" class="form-control" name="password">
                        <small class="text-danger"><?= $passwordError ?? "" ?></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" name="picture">
                    </div>

                    <button type="submit" name="register" class="btn btn-dark w-100 register-btn">
                        Register
                    </button>

                    <p class="text-center mt-3 mb-0">
                        Already have an account?
                        <a href="login.php">Login here</a>
                    </p>

                </form>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
