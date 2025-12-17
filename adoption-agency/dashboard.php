<?php
require_once 'db.php';


$pendingApps = $conn->query("SELECT COUNT(*) AS total FROM adoptionrequest")->fetch_assoc()['total'];


$totalPets = $conn->query("SELECT COUNT(*) AS total FROM animal")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
<h2>Dashboard</h2>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Pending Applications</h5>
                <p class="card-text fs-2"><?= $pendingApps ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Pet Listings</h5>
                <p class="card-text fs-2"><?= $totalPets ?></p>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
