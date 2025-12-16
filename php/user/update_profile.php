<?php
session_start();

require_once "components/db_connect.php";
require_once "components/function.php";
require_once "components/fileupload.php";
require_once "components/profile_pic.php";



if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
 header("Location: php/login/login.php?restricted=true");
 exit;
}

if (!isset($_SESSION["user"])) {
    header("Location: php/login/login.php?restricted=true");
    exit;
}

$username = $_SESSION["user"];


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?php include_once "navbar-user.php"; ?>

<div class="container my-5" style="max-width:600px;">
    <h1>Edit Profile</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" class="form-control" name="name" value="<?= $row["Name"] ?>">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="<?= $row["Email"] ?>">
        </div>

        <div class="mb-3">
            <label>Profile Picture</label>
            <input type="file" class="form-control" name="picture">
        </div>

        <button type="submit" name="update" class="btn btn-warning">Update</button>
        <a href="userprofile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>