<?php
// Always include DB connection and profile functions first
require_once __DIR__ . "/../functions/db_connect.php";
require_once __DIR__ . "/../functions/get_profile.php";
require_once __DIR__ . "/../functions/file_upload.php";
// require_once __DIR__ . "/../functions/user_restriction.php"; // uncomment if you add restrictions

// Validate and fetch pet by ID
$row = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM pets WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("<div class='alert alert-danger'>Pet not found.</div>");
    }
} else {
    die("<div class='alert alert-danger'>Invalid ID.</div>");
}

if (isset($_POST['update_pet'])) {
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

    // Handle picture upload
    if ($_FILES['picture']['error'] == 4) {
        // No new picture uploaded → keep current one
        $updateSql = "UPDATE pets SET 
                      name='$name',
                      breed='$breed',
                      gender='$gender',
                      age='$age',
                      vaccine='$vaccine',
                      size='$size',
                      neutered='$neutered',
                      short_description='$short_description',
                      location='$location',
                      status='$status'
                      WHERE id = $id";
    } else {
        // Delete old picture if not default
        if ($row['picture'] != 'pet.jpg') {
            $oldPath = __DIR__ . "/../images/" . $row['picture'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $picture = fileUploadPet($_FILES['picture']);
        $pictureName = $picture[0];

        $updateSql = "UPDATE pets SET 
                      name='$name',
                      breed='$breed',
                      gender='$gender',
                      age='$age',
                      vaccine='$vaccine',
                      size='$size',
                      neutered='$neutered',
                      short_description='$short_description',
                      location='$location',
                      status='$status',
                      picture='$pictureName'
                      WHERE id = $id";
    }

    $result1 = mysqli_query($conn, $updateSql);
    if ($result1) {
        echo "<div class='alert alert-success'>Pet updated successfully!</div>";
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
    <title>Update Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <div class="container">
        <!-- Navbar include -->
        <?php include __DIR__ . '/navbar.php'; ?>
        <!-- Navbar end-->

        <!-- Main Content Start -->
        <div class="row">
            <div class="col col-md-6 mx-auto">
                <h3 class="mt-5">Update pet</h3>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($row['name']) ?>">
                </div>
                <div class="mb-3">
                    <label for="breed">Breed:</label>
                    <input type="text" class="form-control" id="breed" name="breed" value="<?= htmlspecialchars($row['breed']) ?>">
                </div>
                <div class="mb-3">
                    <label for="gender">Gender:</label>
                    <input type="text" class="form-control" id="gender" name="gender" value="<?= htmlspecialchars($row['gender']) ?>">
                </div>
                <div class="mb-3">
                    <label for="age">Age:</label>
                    <input type="text" class="form-control" id="age" name="age" value="<?= htmlspecialchars($row['age']) ?>">
                </div>
                <div class="mb-3">
                    <label for="vaccine">Vaccine:</label>
                    <input type="text" class="form-control" id="vaccine" name="vaccine" value="<?= htmlspecialchars($row['vaccine']) ?>">
                </div>
                <div class="mb-3">
                    <label for="size">Size:</label>
                    <input type="text" class="form-control" id="size" name="size" value="<?= htmlspecialchars($row['size']) ?>">
                </div>
                <div class="mb-3">
                    <label for="neutered">Neutered:</label>
                    <input type="text" class="form-control" id="neutered" name="neutered" value="<?= htmlspecialchars($row['neutered']) ?>">
                </div>
                <div class="mb-3">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($row['location']) ?>">
                </div>
                <div class="mb-3">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Available" <?= $row['status'] === 'Available' ? 'selected' : '' ?>>Available</option>
                        <option value="Adopted" <?= $row['status'] === 'Adopted' ? 'selected' : '' ?>>Adopted</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="short_description">Short description</label>
                    <input type="text" class="form-control" id="short_description" name="short_description" value="<?= htmlspecialchars($row['short_description']) ?>">
                </div>
                <div class="mb-3">
                    <label for="picture">Picture</label>
                    <input type="file" class="form-control" id="picture" name="picture">
                </div>
                <input type="submit" class="btn btn-success" name="update_pet" value="submit">
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
