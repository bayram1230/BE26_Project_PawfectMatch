<?php
require_once "../../components/db_connect.php";
require_once "../../components/function.php";



session_start();


if (isset($_SESSION["admin"])) {
    header("Location: ../../dashboard.php");
    exit();
}

if (isset($_SESSION["user"])) {
   header("Location: ../../index.php");
    exit();
}


if (isset($_GET["restricted"]) && $_GET["restricted"] == "true") {
    $pageMessage = "You don't have access to this page";
}



$error = false;

if (isset($_POST["login"])) {

    $email = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);

   
    if (empty($email)) {
        $error = true;
        $emailError = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Invalid email format";
    }

    
    if (empty($password)) {
        $error = true;
        $passwordError = "Password is required";
    }

    if (!$error) {

        $password = hash("sha256", $password);

        
        $sql = "SELECT * FROM Users WHERE Email = '$email' AND Password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_assoc($result);

            
            if ($row["Role"] == "admin") {
                $_SESSION["admin"] = $row["Username"]; 
                header("Location: ../../dashboard.php");
                exit();
            }

            
            $_SESSION["user"] = $row["Username"];
            header("Location: ../../index.php");
            exit();

        } else {
            $pageMessage = "Your email or password is incorrect";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="css/style.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="../../css/style.css" rel="stylesheet">


    <style>
        body {
            background: #f4f6f8;
        }
        .login-card {
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            background: #9affb4;
        }
        .login-card input {
            border-radius: 8px;
        }
        .login-btn {
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>
<body class="body-pic">

<div class="container my-5">

   
    <h1 class="text-center mb-4 fw-bold">
        <img 
            src="../../img/logo.png" 
            alt="Pawfect Match Logo"
            style="max-width: 220px; height: auto;"
        >
    </h1>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card login-card p-4">

             
                <?php if (!empty($pageMessage)): ?>
                    <div class="alert alert-danger text-center">
                        <?= $pageMessage ?>
                    </div>
                <?php endif; ?>

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email">
                        <small class="text-danger"><?= $emailError ?? "" ?></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" class="form-control" name="password">
                        <small class="text-danger"><?= $passwordError ?? "" ?></small>
                    </div>

                    <button type="submit" name="login" class="btn btn-dark w-100 login-btn">
                        Login
                    </button>

                    <p class="text-center mt-3 mb-0">
                        Don’t have an account?
                        <a href="register.php">Create one</a>
                    </p>

                </form>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>