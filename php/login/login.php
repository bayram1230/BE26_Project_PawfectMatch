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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="my-4">Login</h1>

    <p class="text-danger"><?= $pageMessage ?? "" ?></p>

    <form method="post">

        <div class="mb-3">
            <label>Email address</label>
            <input type="email" class="form-control" name="email">
            <p class="text-danger"><?= $emailError ?? "" ?></p>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
            <p class="text-danger"><?= $passwordError ?? "" ?></p>
        </div>

        <button type="submit" class="btn btn-primary" name="login">Login!</button>
        <span><a href="register.php">Create an account</a></span>

    </form>
</div>

</body>
</html>
