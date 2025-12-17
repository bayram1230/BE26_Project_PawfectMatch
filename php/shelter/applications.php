<?php
require_once 'db.php';


if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']); 
    $status = $_GET['action'] === 'approve' ? 'Approved' : 'Rejected';
    $conn->query("UPDATE adoptionhistory SET Status='$status' WHERE ID=$id");
}


$apps = $conn->query("
    SELECT ah.ID as appID, ah.Status, ah.RequestDate, ah.Username, a.Name AS AnimalName 
    FROM adoptionhistory ah 
    JOIN animal a ON ah.AnimalID = a.ID
    ORDER BY ah.RequestDate DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Applications</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
<h2>Adoption Applications</h2>

<?php if($apps->num_rows > 0): ?>
    <?php while($app = $apps->fetch_assoc()): ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($app['Username']) ?> - <?= htmlspecialchars($app['AnimalName']) ?></h5>
            <p><strong>Request Date:</strong> <?= $app['RequestDate'] ?></p>
            <p><strong>Status:</strong> <?= $app['Status'] ?></p>
            <?php if($app['Status'] === 'Pending'): ?>
                <a href="?action=approve&id=<?= $app['appID'] ?>" class="btn btn-success btn-sm">Approve</a>
                <a href="?action=reject&id=<?= $app['appID'] ?>" class="btn btn-danger btn-sm">Reject</a>
            <?php else: ?>
                <span class="badge <?= $app['Status'] === 'Approved' ? 'bg-success' : 'bg-danger' ?>"><?= $app['Status'] ?></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No applications found.</p>
<?php endif; ?>

</div>
</body>
</html>
