<?php
require_once "../../components/db_connect.php";
require_once "../../components/function.php";

$error = false;

if (isset($_POST["register"])) {

    $username = cleanInput($_POST["username"]);
    $name     = cleanInput($_POST["name"]);
    $email    = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);

   
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
            INSERT INTO Users (Username, Password, Name, Email, Role)
            VALUES ('$username', '$password', '$name', '$email', 'user')
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
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Register</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>

<div class='container my-5'>
    <h1>User Registration</h1>
    <?= $success ?? "" ?>

    <form method='post'>

        <div class='mb-3'>
            <label>Username *</label>
            <input type='text' class='form-control' name='username' value='<?= $username ?? "" ?>'>
            <p class='text-danger'><?= $usernameError ?? "" ?></p>
        </div>

        <div class='mb-3'>
            <label>Name *</label>
            <input type='text' class='form-control' name='name' value='<?= $name ?? "" ?>'>
            <p class='text-danger'><?= $nameError ?? "" ?></p>
        </div>

        <div class='mb-3'>
            <label>Email *</label>
            <input type='text' class='form-control' name='email' value='<?= $email ?? "" ?>'>
            <p class='text-danger'><?= $emailError ?? "" ?></p>
        </div>

        <div class='mb-3'>
            <label>Password *</label>
            <input type='password' class='form-control' name='password'>
            <p class='text-danger'><?= $passwordError ?? "" ?></p>
        </div>

        <button type='submit' name='register' class='btn btn-primary'>Register</button>
        <span>Already have an account? <a href='login.php'>Login here</a></span>

    </form>
</div>

</body>
</html>
