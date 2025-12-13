<?php
session_start();

require_once "components/db_connect.php";
require_once "components/profile_pic.php";

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: php/login/login.php?restricted=true");
    exit;
}

if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
    exit;
}

// alle tiere holen
$sql = "SELECT * FROM animal";
$result = mysqli_query($conn, $sql);

$layout = "";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $layout .= "
            <div class='col-md-4 mb-4'>
                <div class='card custom-card h-100'>
                    <img src='img/" . htmlspecialchars($row['img']) . "' 
                         class='custom-card-img'
                         alt='" . htmlspecialchars($row['Name']) . "'>

                    <div class='card-body custom-card-body'>
                        <h5 class='card-title'>" . htmlspecialchars($row['Name']) . "</h5>
                        <hr class='card-hr'>
                        <h4 class='card-text'>Type: " . htmlspecialchars($row['Type']) . "</h4>
                        <h4 class='card-text'>Age: " . htmlspecialchars($row['Age']) . " years</h4>
                        <h4 class='card-text'>Breed: " . htmlspecialchars($row['Breed']) . "</h4>
                    </div>

                    <div class='d-flex justify-content-center mb-3'>
                        <a href='pet_details.php?id={$row['ID']}' class='btn card-btn'>
                            More Details
                        </a>
                    </div>
                </div>
            </div>
        ";
    }
} else {
    $layout = "<h3 class='my-3 text-center'>No animals found</h3>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Pets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php
include_once "navbar-user.php";
?>
<div class="container my-5">
    <h1 class="custom-card-h1 text-center mb-4">
        Current list of available pets
    </h1>

    <div class="row">
        <?= $layout ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
