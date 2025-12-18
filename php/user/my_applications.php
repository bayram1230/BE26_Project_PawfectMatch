<?php
session_start();
require_once __DIR__ . "/../../components/db_connect.php";
require_once __DIR__ . "/../functions/get_profile.php";
require_once __DIR__ . "/../functions/user_restriction.php";

requireUser(); // nur User darf rein



$username = $_SESSION["username"];

// alle Bewerbungen des Users holen mit Tierdetails
$sql = "
    SELECT 
    AdoptionRequest.ID,AdoptionRequest.RequestDate,Animal.Name,Animal.Type,Animal.Breed FROM AdoptionRequest
    JOIN Animal ON AdoptionRequest.AnimalID = Animal.ID
    WHERE AdoptionRequest.Username = '$username'
";
    
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link href="../../css/style.css" rel="stylesheet">
</head>
<body class="body-pic">

<?php require_once "../../components/navbar.php"; ?>
<?php require_once __DIR__ . "/user_menu.php"; ?>
<?php require_once __DIR__ . "/btn.php"; ?>

<div class="container my-5">
    <h1 class="mb-4 text-center text-white">My Applications</h1>

    <?php
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    
            echo "
            <div class='card mb-3 shadow-sm'>
                <div class='card-body'>
                    <h5 class='card-title'>
                        Animal: " . htmlspecialchars($row['Name']) . "
                    </h5>
                    <p><strong>Type:</strong> " . htmlspecialchars($row['Type']) . "</p>
                    <p><strong>Breed:</strong> " . htmlspecialchars($row['Breed']) . "</p>
                    <p><strong>Request Date:</strong> " . $row['RequestDate'] . "</p>
                </div>
            </div>";
        }
    } else {
        echo "<p class='text-center text-white'>You have no adoption applications yet.</p>";
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
