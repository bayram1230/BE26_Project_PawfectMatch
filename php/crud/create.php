<?php
session_start();

require_once __DIR__ . "/../../components/db_connect.php";
require_once __DIR__ . "/../functions/get_profile.php";
require_once __DIR__ . "/../functions/user_restriction.php";

/* ---------------------------------
   Shelter-only protection
---------------------------------- */
requireShelter();

/* ---------------------------------
   Profile picture
---------------------------------- */
$profilePic = getProfilePicture($conn);

/* ---------------------------------
   Message layout
---------------------------------- */
$layout  = "";
$message = "";

/* ---------------------------------
   PROCESS FORM SUBMISSION
---------------------------------- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $type        = mysqli_real_escape_string($conn, $_POST["type"]);
    $name        = mysqli_real_escape_string($conn, $_POST["name"]);
    $breed       = mysqli_real_escape_string($conn, $_POST["breed"]);
    $sex         = mysqli_real_escape_string($conn, $_POST["sex"]);
    $age         = intval($_POST["age"]);
    $color       = mysqli_real_escape_string($conn, $_POST["color"]);
    $size        = mysqli_real_escape_string($conn, $_POST["size"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $adoption_requirements = mysqli_real_escape_string($conn, $_POST["adoption_requirements"]);

    /* ---------------------------------
       IMAGE HANDLING
    ---------------------------------- */
    $imageName = "default-animals.png";

    if (!empty($_POST["img_url"]) && filter_var($_POST["img_url"], FILTER_VALIDATE_URL)) {
        $imageName = $_POST["img_url"];
    } elseif (!empty($_FILES["img"]["name"])) {
        $imageName = time() . "_" . basename($_FILES["img"]["name"]);
        $targetDir = "../../img/animals/";
        if (!move_uploaded_file($_FILES["img"]["tmp_name"], $targetDir . $imageName)) {
            $imageName = "default-animals.png";
        }
    }

    /* ---------------------------------
       SQL INSERT (using ImageUrl)
    ---------------------------------- */
    $sql = "
        INSERT INTO animal 
            (Type, Name, Breed, Sex, Age, Color, Size, Description, adoption_requirements, ImageUrl)
        VALUES
            ('$type', '$name', '$breed', '$sex', $age, '$color', '$size', 
             '$description', '$adoption_requirements', '$imageName')
    ";

    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert alert-success text-center'>Animal successfully added!</div>";
    } else {
        $message = "<div class='alert alert-danger text-center'>Error: " . mysqli_error($conn) . "</div>";
    }
}

/* ---------------------------------
   Build form layout
---------------------------------- */
$layout = "
<div class='card paw-card text-center'>
    <div class='card-body details-card-body'>
        $message
        <form method='POST' enctype='multipart/form-data' class='text-start'>
            <label class='form-label'>Type</label>
            <select name='type' class='form-select mb-3' required>
                <option value='Dog'>Dog</option>
                <option value='Cat'>Cat</option>
                <option value='Other'>Other</option>
            </select>

            <label class='form-label'>Name</label>
            <input type='text' name='name' class='form-control mb-3' required>

            <label class='form-label'>Breed</label>
            <input type='text' name='breed' class='form-control mb-3'>

            <label class='form-label'>Sex</label>
            <select name='sex' class='form-select mb-3'>
                <option value='Male'>Male</option>
                <option value='Female'>Female</option>
                <option value='Unknown'>Unknown</option>
            </select>

            <label class='form-label'>Age</label>
            <input type='number' name='age' class='form-control mb-3' min='0'>

            <label class='form-label'>Color</label>
            <input type='text' name='color' class='form-control mb-3'>

            <label class='form-label'>Size</label>
            <input type='text' name='size' class='form-control mb-3'>

            <label class='form-label'>Description</label>
            <textarea name='description' class='form-control mb-3' rows='4'></textarea>

            <label class='form-label'>Adoption Requirements</label>
            <textarea name='adoption_requirements' class='form-control mb-3' rows='4' placeholder='e.g. Must be 18+, no other pets, fenced yard required' required></textarea>

            <label class='form-label'>Image (Upload)</label>
            <input type='file' name='img' class='form-control mb-3'>

            <label class='form-label'>Image URL (optional)</label>
            <input type='url' name='img_url' class='form-control mb-4' placeholder='https://example.com/image.jpg'>

            <button class='btn btn-success w-100'>Create Animal</button>
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
    <title>Add a new pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="body-pic">

<div class="container details-container mt-5">
    <h1 class="paw-card-h1">Add a new pet</h1>
    <div class="row">
        <?= $layout ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
