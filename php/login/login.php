<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "../../components/db_connect.php";
require_once "../../components/function.php";
require_once "../functions/get_profile.php";
/* ---------------------------------
   Already logged in?
---------------------------------- */
if (isset($_SESSION['username'], $_SESSION['role'], $_SESSION['user_id'])) {
    header("Location: " . getProfileLink());
    exit;
}
$error = false;
$pageMessage = "";
$emailError = "";
$passwordError = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = cleanInput($_POST["email"] ?? "");
    $password = cleanInput($_POST["password"] ?? "");
    /* ---------------------------------
       Validation
    ---------------------------------- */
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
    /* ---------------------------------
       Login
    ---------------------------------- */
    if (!$error) {
        $hashedPassword = hash("sha256", $password);
        $sql = "SELECT id, Username, Role
                FROM users
                WHERE Email = ? AND Password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            /* :schlüssel: COMPLETE session setup */
            $_SESSION['user_id']  = (int) $row['id'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['role']     = $row['Role'];
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
    <title>Login</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h1 class="mb-4 text-center">Login</h1>
    <?php if (!empty($pageMessage)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($pageMessage) ?>
        </div>
    <?php endif; ?>
    <form method="post" action="login.php">
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input
                type="email"
                class="form-control"
                name="email"
                required
            >
            <div class="text-danger"><?= htmlspecialchars($emailError) ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input
                type="password"
                class="form-control"
                name="password"
                required
            >
            <div class="text-danger"><?= htmlspecialchars($passwordError) ?></div>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                Login
            </button>
        </div>
        <div class="text-center mt-3">
            <a href="register.php">Create an account</a>
        </div>
    </form>
</div>
</body>
</html>