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


$username = $_SESSION["user"];



$typeFilter = $_GET["type"] ?? "";
$ageFilter  = $_GET["age"] ?? "";
$breedFilter = $_GET["breed"] ?? "";


$sql = "SELECT * FROM Animal WHERE 1=1 ";

// filter type
if (!empty($typeFilter)) {
    $sql .= " AND Type = '$typeFilter'";
}

// filter age
if (!empty($ageFilter)) {
    $sql .= " AND Age <= $ageFilter";
}

// filter breed
if (!empty($breedFilter)) {
    $sql .= " AND Breed LIKE '%$breedFilter%'";
}

$result = mysqli_query($conn, $sql);


$layout = "";

if (mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($rows as $row) {
      $layout .= "
<div class='col'>
    <div class='card paw-card paw-card--index'>
        <div class='paw-card-inner'>
            <div class='paw-card-content'>

                <img
                    src='img/" . htmlspecialchars($row['img']) . "'
                    class='paw-card-img'
                    alt='" . htmlspecialchars($row['Name']) . "'
                    onerror=\"this.src='img/default-animals.png'\"
                >

                <div class='paw-card-title-wrapper'>
                    <h5 class='paw-card-title'>" . htmlspecialchars($row['Name']) . "</h5>
                    <hr class='index-card-hr'>
                    <p class='paw-card-meta'>
                        Type: " . htmlspecialchars($row['Type']) . "<br>
                        Breed: " . htmlspecialchars($row['Breed']) . "<br>
                        Age: " . htmlspecialchars($row['Age']) . "
                    </p>
                </div>

                <div class='d-flex flex-column gap-2'>
                    <a href='pet_details.php?id=" . $row['ID'] . "' class='btn paw-card-btn'>
                        🐾 More Details 🐾
                    </a>
                    <a href='apply.php?id=" . $row['ID'] . "' class='btn btn-success'>
                        Take Me Home
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
";
    }
} else {
    $layout = "<h3 class='text-white'>No pets found matching your filters.</h3>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Pets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link href="css/style.css" rel="stylesheet">
</head>

<body class="body-pic">


<?php
include_once "navbar-user.php";
?>  



<div class="container my-4">

    <h2 class="mb-4 text-white">Search Pets</h2>

    <form method="GET" class="row g-3">

        <div class="col-md-3">
            <label class="text-white">Type</label>
            <select name="type" class="form-control">
                <option value="">All</option>
                <option value="Dog" <?= $typeFilter == "Dog" ? "selected" : "" ?>>Dog</option>
                <option value="Cat" <?= $typeFilter == "Cat" ? "selected" : "" ?>>Cat</option>
                <option value="Other" <?= $typeFilter == "Other" ? "selected" : "" ?>>Other</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="text-white">Max Age</label>
            <input type="number" name="age" class="form-control" min="0" value="<?= $ageFilter ?>">

        </div>

        <div class="col-md-3">
            <label  class="text-white">Breed</label>
            <input type="text" name="breed" class="form-control" value="<?= $breedFilter ?>">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">Apply Filters</button>
        </div>

    </form>

</div>


<div class="container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
        <?= $layout ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
