<?php
require_once "../../components/db_connect.php";


if(!is_dir('uploads')){
    mkdir('uploads', 0777, true);
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])){
    $file = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$file);
    echo "<div class='alert alert-success'>Resource uploaded!</div>";
}


if(isset($_GET['delete'])){
    $fileToDelete = 'uploads/'.basename($_GET['delete']);
    if(file_exists($fileToDelete)) unlink($fileToDelete);
    echo "<div class='alert alert-danger'>Resource deleted!</div>";
}


$files = array_diff(scandir('uploads'), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Resources</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
<h2>Resources</h2>

<form method="post" enctype="multipart/form-data" class="mb-4">
    <input type="file" name="file" required>
    <button type="submit" class="btn btn-primary btn-sm">Upload</button>
</form>

<h4>Uploaded Resources</h4>
<ul class="list-group">
<?php foreach($files as $file): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="uploads/<?= htmlspecialchars($file) ?>" target="_blank"><?= htmlspecialchars($file) ?></a>
        <a href="?delete=<?= urlencode($file) ?>" class="btn btn-danger btn-sm">Delete</a>
    </li>
<?php endforeach; ?>
</ul>

</div>
</body>
</html>
