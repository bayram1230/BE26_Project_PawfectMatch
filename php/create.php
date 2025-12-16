<?php
// Always include DB connection and profile functions first
require_once __DIR__ . "/../functions/db_connect.php";
require_once __DIR__ . "/../functions/get_profile.php";
require_once __DIR__ . "/../functions/file_upload.php";
// require_once __DIR__ . "/../functions/user_restriction.php"; // uncomment if you add restrictions

if (isset($_POST['add_pet'])) {
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $vaccine = $_POST['vaccine'];
    $size = $_POST['size'];
    $neutered = $_POST['neutered'];
    $short_description = $_POST['short_description'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    // Handle picture upload or fallback to default
    if ($_FILES['picture']['error'] == 4) {
        // No file uploaded → use default
        $pictureName = "pet.jpg";
        $uploadMessage = "Default picture used.";
    } else {
        $picture = fileUploadPet($_FILES['picture']);
        $pictureName = $picture[0];
        $uploadMessage = $picture[1];
    }

    $sql = "INSERT INTO pets 
            (name, breed, gender, age, vaccine, size, neutered, short_description, location, status, picture)
            VALUES 
            ('$name', '$breed', '$gender', '$age', '$vaccine', '$size', '$neutered', '$short_description', '$location', '$status', '$pictureName')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<div class='alert alert-success'>New pet has been added! $uploadMessage</div>";
    } else {
        echo "<div class='alert alert-danger'>Something went wrong! " . mysqli_error($conn) . "</div>";
    }

    header("refresh: 3; url=../../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <div class="container">
        <!-- Navbar include -->
        <?php include __DIR__ . '/navbar.php'; ?>
        <!-- Navbar end -->

        <!-- Main Content Start -->
        <div class="row">
            <div class="col col-md-6 mx-auto">
                <h3 class="mt-5">Add pet</h3>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="breed">Breed:</label>
                    <input type="text" class="form-control" id="breed" name="breed">
                </div>
                <div class="mb-3">
                    <label for="gender">Gender:</label>
                    <input type="text" class="form-control" id="gender" name="gender">
                </div>
                <div class="mb-3">
                    <label for="age">Age:</label>
                    <input type="text" class="form-control" id="age" name="age">
                </div>
                <div class="mb-3">
                    <label for="vaccine">Vaccine:</label>
                    <input type="text" class="form-control" id="vaccine" name="vaccine">
                </div>
                <div class="mb-3">
                    <label for="size">Size:</label>
                    <input type="text" class="form-control" id="size" name="size">
                </div>
                <div class="mb-3">
                    <label for="neutered">Neutered:</label>
                    <input type="text" class="form-control" id="neutered" name="neutered">
                </div>
                <div class="mb-3">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location">
                </div>
                <div class="mb-3">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Available">Available</option>
                        <option value="Adopted">Adopted</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="short_description">Short description:</label>
                    <input type="text" class="form-control" id="short_description" name="short_description">
                </div>
                <div class="mb-3">
                    <label for="picture">Picture:</label>
                    <input type="file" class="form-control" id="picture" name="picture">
                </div>
                <input type="submit" class="btn btn-success" name="add_pet" value="submit">
            </form>
        </div>
        <!-- Main Content End -->

        <!-- Footer include -->
        <?php include __DIR__ . '/footer.php'; ?>
        <!-- Footer End -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
