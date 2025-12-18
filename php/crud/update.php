<?php
session_start();

require_once __DIR__ . "/../functions/user_restriction.php";
requireAdminOrShelter();

require_once __DIR__ . "/../../components/db_connect.php";
require_once __DIR__ . "/../functions/get_profile.php";

/* ---------------------------------
   Profile picture
---------------------------------- */
$profilePic = getProfilePicture($conn) ?? "default-users.png";

/* ---------------------------------
   Check ID
---------------------------------- */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<h3>No valid ID provided.</h3>");
}

$id = intval($_GET['id']);

/* ---------------------------------
   Fetch current animal
---------------------------------- */
$sql = "SELECT * FROM animal WHERE ID = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) !== 1) {
    die("<h3>Animal not found.</h3>");
}

$row = mysqli_fetch_assoc($result);
$message = "";

/* ---------------------------------
   Handle UPDATE
---------------------------------- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $type = mysqli_real_escape_string($conn, $_POST["type"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $breed = mysqli_real_escape_string($conn, $_POST["breed"]);
    $sex = mysqli_real_escape_string($conn, $_POST["sex"]);
    $age = intval($_POST["age"]);
    $color = mysqli_real_escape_string($conn, $_POST["color"]);
    $size = mysqli_real_escape_string($conn, $_POST["size"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $adoption_requirements = mysqli_real_escape_string($conn, $_POST["adoption_requirements"]);
    $img_url = trim($_POST["img_url"]);

    $imageName = $row['ImageUrl']; // keep existing by default

    /* IMAGE HANDLING */
    if (!empty($img_url) && filter_var($img_url, FILTER_VALIDATE_URL)) {
        $imageName = $img_url;
    } elseif (!empty($_FILES["img"]["name"])) {

        $imageName = time() . "_" . basename($_FILES["img"]["name"]);
        $targetDir = "../../img/animals/";

        if (!move_uploaded_file($_FILES["img"]["tmp_name"], $targetDir . $imageName)) {
            $imageName = $row['ImageUrl'];
        }
    }

    /* ---------------------------------
       Update database
    ---------------------------------- */
    $updateSql = "
        UPDATE animal SET
            Type = '$type',
            Name = '$name',
            Breed = '$breed',
            Sex = '$sex',
            Age = $age,
            Color = '$color',
            Size = '$size',
            Description = '$description',
            adoption_requirements = '$adoption_requirements',
            ImageUrl = '$imageName'
        WHERE ID = $id
    ";

    if (mysqli_query($conn, $updateSql)) {
        header("Location: details.php?id=$id&updated=1");
        exit;
    } else {
        $message = "<div class='alert alert-danger'>Update failed: " . mysqli_error($conn) . "</div>";
    }
}

/* ---------------------------------
   Build form layout
---------------------------------- */
$layout = "
<div class='card details-card text-center'>
    <div class='card-body details-card-body'>

        $message

        <form method='POST' enctype='multipart/form-data' class='text-start'>

            <label class='form-label'>Type</label>
            <select name='type' class='form-select mb-3'>
                <option value='Dog' ".($row['Type']=='Dog'?'selected':'').">Dog</option>
                <option value='Cat' ".($row['Type']=='Cat'?'selected':'').">Cat</option>
                <option value='Other' ".($row['Type']=='Other'?'selected':'').">Other</option>
            </select>

            <label class='form-label'>Name</label>
            <input type='text' name='name' class='form-control mb-3'
                   value='".htmlspecialchars($row['Name'])."' required>

            <label class='form-label'>Breed</label>
            <input type='text' name='breed' class='form-control mb-3'
                   value='".htmlspecialchars($row['Breed'])."'>

            <label class='form-label'>Sex</label>
            <select name='sex' class='form-select mb-3'>
                <option value='Male' ".($row['Sex']=='Male'?'selected':'').">Male</option>
                <option value='Female' ".($row['Sex']=='Female'?'selected':'').">Female</option>
                <option value='Unknown' ".($row['Sex']=='Unknown'?'selected':'').">Unknown</option>
            </select>

            <label class='form-label'>Age</label>
            <input type='number' name='age' class='form-control mb-3'
                   value='{$row['Age']}' min='0'>

            <label class='form-label'>Color</label>
            <input type='text' name='color' class='form-control mb-3'
                   value='".htmlspecialchars($row['Color'])."'>

            <label class='form-label'>Size</label>
            <input type='text' name='size' class='form-control mb-3'
                   value='".htmlspecialchars($row['Size'])."'>

            <label class='form-label'>Description</label>
            <textarea name='description' class='form-control mb-3'
                      rows='4'>".htmlspecialchars($row['Description'])."</textarea>

            <label class='form-label'>Adoption Requirements</label>
            <textarea name='adoption_requirements' class='form-control mb-3'
                      rows='3'>".htmlspecialchars($row['adoption_requirements'])."</textarea>

            <label class='form-label'>Image (Upload)</label>
            <input type='file' name='img' class='form-control mb-3'>

            <label class='form-label'>Image URL (optional)</label>
            <input type='url' name='img_url' class='form-control mb-4'
                   placeholder='https://example.com/image.jpg'>

            <button class='inline-btn w-100'>
                Update Animal
            </button>

        </form>
    </div>
</div>
";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update pet</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg custom-navbar sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">
            <img src="/img/navbar-logo.png" alt="logo" class="navbar-logo">
        </a>
    </div>
</nav>

<div class="container details-container">
    <h1 class="paw-card-h1">Update pet</h1>
    <div class="row">
        <?= $layout ?>
    </div>
</div>

<footer class="mt-auto py-4">
    <div class="copyright">
        © 2025 Copyright: Group 1
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
