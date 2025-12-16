<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

$layout = "";

// Validate and fetch pet by ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM pets WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Ensure picture always has a value
        $picture = !empty($row['picture']) ? $row['picture'] : "pet.jpg";
        $picturePath = "img/" . htmlspecialchars($picture);

        $layout = "
        <div class='container mt-5'>
            <div class='card card-border shadow'>
                <div class='card-body details-body text-center'>
                    <h4 class='card-title mb-4'>" . htmlspecialchars($row['name']) . "</h4>
                    <p>" . (!empty($row['short_description']) ? htmlspecialchars($row['short_description']) : 'No description available.') . "</p>
                    <hr class='line'>
                    <img src='" . $picturePath . "' class='img-fluid rounded mx-auto d-block mb-3' alt='" . htmlspecialchars($row['name']) . "'>
                    <table class='border-table mx-auto mb-3'>
                        <tr><th>Breed:</th><td>" . (!empty($row['breed']) ? htmlspecialchars($row['breed']) : 'Unknown') . "</td></tr>
                        <tr><th>Gender:</th><td>" . (!empty($row['gender']) ? htmlspecialchars($row['gender']) : 'Not specified') . "</td></tr>
                        <tr><th>Age:</th><td>" . htmlspecialchars($row['age']) . "</td></tr>
                        <tr><th>Location:</th><td>" . (!empty($row['location']) ? htmlspecialchars($row['location']) : 'Not specified') . "</td></tr>
                        <tr><th>Vaccine:</th><td>" . (!empty($row['vaccine']) ? htmlspecialchars($row['vaccine']) : 'Not specified') . "</td></tr>
                        <tr><th>Size:</th><td>" . (!empty($row['size']) ? htmlspecialchars($row['size']) : 'Not specified') . "</td></tr>
                        <tr><th>Neutered:</th><td>" . (!empty($row['neutered']) ? htmlspecialchars($row['neutered']) : 'Not specified') . "</td></tr>
                        <tr><th>Status:</th><td>" . htmlspecialchars($row['status']) . "</td></tr>
                    </table>
                    <div class='mt-3'>";
        // Match lowercase ENUM values
        if ($row['status'] === 'available') {
            $layout .= "<a href='foster.php?id=" . intval($row['id']) . "' class='btn btn-warning'>Foster this Pet</a>";
        } elseif ($row['status'] === 'fostered') {
            $layout .= "<a href='adopt.php?id=" . intval($row['id']) . "' class='btn btn-success'>Finalize Adoption</a>";
        } elseif ($row['status'] === 'adopted') {
            $layout .= "<span class='badge bg-secondary'>Already Adopted</span>";
        }
        $layout .= "
                    </div>
                </div>
            </div>
        </div>";
    } else {
        $layout = "<div class='container mt-5'><h3>No data found</h3></div>";
    }
} else {
    $layout = "<div class='container mt-5'><h3>Invalid ID</h3></div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar OUTSIDE container -->
    <?php include __DIR__ . '/navbar.php'; ?>

    <!-- Page content -->
    <?= $layout; ?>

    <!-- Footer OUTSIDE container -->
    <?php include __DIR__ . '/footer.php'; ?>

    <!-- Bootstrap JS bundle for dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
