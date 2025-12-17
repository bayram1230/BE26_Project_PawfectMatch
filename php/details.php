<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";

// Helper function to format status values
function formatStatus($status) {
    switch ($status) {
        case 'pet_of_day': return 'Pet of the Day';
        case 'pet_of_week': return 'Pet of the Week';
        case 'fostered': return 'Fostered';
        case 'adopted': return 'Adopted';
        case 'available': return 'Available';
        default: return ucfirst($status);
    }
}

$layout = "";

// Validate and fetch pet by ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM pets WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Ensure picture always has a value
        $picture = !empty($row['picture']) ? $row['picture'] : "default-animals.png";
        $picturePath = "../img/" . htmlspecialchars($picture);

        $layout = "
        <div class='container index-container mt-5'>
            <div class='card paw-card paw-card--index shadow'>
                <div class='card-body details-body text-center bg-light'>
                    <h2 class='paw-card-h1 mb-4 text-dark'>" . htmlspecialchars($row['name']) . "</h2>
                    <p class='lead text-dark mb-3'>" . (!empty($row['short_description']) ? htmlspecialchars($row['short_description']) : 'No description available.') . "</p>
                    <hr class='index-card-hr'>
                    <img src='" . $picturePath . "' 
                         class='img-fluid rounded mx-auto d-block mb-3 paw-card-img' 
                         alt='" . htmlspecialchars($row['name']) . "'
                         onerror=\"this.src='../img/default-animals.png'\">
                    <table class='table table-striped table-bordered w-75 mx-auto mb-3'>
        ";

        // Only show fields if they have values
        $fields = [
            "Breed" => $row['breed'] ?? '',
            "Gender" => $row['gender'] ?? '',
            "Age" => $row['age'] ?? '',
            "Location" => $row['location'] ?? '',
            "Vaccine" => $row['vaccine'] ?? '',
            "Size" => $row['size'] ?? '',
            "Neutered" => $row['neutered'] ?? '',
            "Status" => formatStatus($row['status'] ?? '')
        ];

        foreach ($fields as $label => $value) {
            if (!empty($value)) {
                $layout .= "<tr><th>$label</th><td>" . htmlspecialchars($value) . "</td></tr>";
            }
        }

        $layout .= "
                    </table>
                    <div class='mt-3'>";
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
        $layout = "<div class='container mt-5'><div class='alert alert-info'>No data found.</div></div>";
    }
} else {
    $layout = "<div class='container mt-5'><div class='alert alert-danger'>Invalid ID.</div></div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <style>
      footer { position: fixed; bottom: 0; left: 0; width: 100%; padding: 1rem 0; }
      body { margin-bottom: 120px; }
      .index-container { padding-bottom: 140px; }
    </style>
</head>
<body class="body-pic">

    <!-- Page content -->
    <?= $layout; ?>

    <!-- Footer -->
    <?php include __DIR__ . '/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
