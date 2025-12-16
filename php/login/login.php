<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once "../../components/db_connect.php";
require_once "../../components/function.php";
require_once "../functions/get_profile.php";


// Schon eingeloggt?
if (isset($_SESSION['username'], $_SESSION['role'])) {
    header("Location: " . getProfileLink());
    exit;
}

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


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

        $sql = "SELECT Username, Role FROM users WHERE Email = ? AND Password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            // 🔑 NEUE Session-Logik
            $_SESSION['username'] = $row['Username'];
            $_SESSION['role'] = $row['Role'];

            // Weiterleitung je nach Rolle
            header("Location: " . getProfileLink());
            exit;

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

    <form method="post" action="login.php">


        <div class="mb-3">
            <label>Email address</label>
            <input type="email" class="form-control" name="email" required>
            <p class="text-danger"><?= $emailError ?? "" ?></p>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" name="password" required>
            <p class="text-danger"><?= $passwordError ?? "" ?></p>
        </div>

        <input type="submit" name="login" value="Login!" class="btn btn-primary">

        <span><a href="register.php">Create an account</a></span>

    </form>
</div>

</body>
</html>
