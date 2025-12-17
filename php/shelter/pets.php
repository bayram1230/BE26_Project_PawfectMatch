<?php
require_once 'db.php';


if(isset($_GET['edit'])){
    $edit_id = intval($_GET['edit']);
    $edit_pet = $conn->query("SELECT * FROM animal WHERE ID=$edit_id")->fetch_assoc();
}


if(isset($_POST['update_pet']) && isset($_POST['id'])){
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $type = $_POST['type'];
    $breed = $conn->real_escape_string($_POST['breed']);
    $age = intval($_POST['age']);
    $sex = $_POST['sex'];
    $color = $conn->real_escape_string($_POST['color']);
    $size = $conn->real_escape_string($_POST['size']);
    $description = $conn->real_escape_string($_POST['description']);
    $requirements = $conn->real_escape_string($_POST['requirements']);
    $imageInput = trim($_POST['image'] ?? '');
    $image = $imageInput !== '' ? $conn->real_escape_string($imageInput) : 'default-animals.png';

    $conn->query("UPDATE animal SET Name='$name', Type='$type', Breed='$breed', Age=$age, Sex='$sex', Color='$color', Size='$size', Description='$description', adoption_requirements='$requirements', ImageUrl='$image' WHERE ID=$id");
}


if(isset($_POST['add_pet'])){
    $name = $conn->real_escape_string($_POST['name']);
    $type = $_POST['type'];
    $breed = $conn->real_escape_string($_POST['breed']);
    $age = intval($_POST['age']);
    $sex = $_POST['sex'];
    $color = $conn->real_escape_string($_POST['color']);
    $size = $conn->real_escape_string($_POST['size']);
    $description = $conn->real_escape_string($_POST['description']);
    $requirements = $conn->real_escape_string($_POST['requirements']);
    $imageInput = trim($_POST['image'] ?? '');
    $image = $imageInput !== '' ? $conn->real_escape_string($imageInput) : 'default-animals.png';

    $conn->query("INSERT INTO animal (Name, Type, Breed, Age, Sex, Color, Size, Description, adoption_requirements, ImageUrl) 
    VALUES ('$name','$type','$breed','$age','$sex','$color','$size','$description','$requirements','$image')");

    if($conn->error){
        echo "MySQL Error: " . $conn->error;
    }
}


if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM animal WHERE ID=$id");
}

$pets = $conn->query("SELECT * FROM animal ORDER BY ID DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Listings</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<style>
.card-img-top {
    width: 100%;
    height: 400px; 
    object-fit: cover;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover .card-img-top {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0,0,0,0.3);
}
</style>
</head>
<body>
<div class="container mt-5">
<h2>Pet Listings</h2>


<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title"><?= isset($edit_pet) ? 'Edit Pet' : 'Add New Pet' ?></h5>
        <form method="post">
            <?php if(isset($edit_pet)): ?>
                <input type="hidden" name="id" value="<?= $edit_pet['ID'] ?>">
            <?php endif; ?>
            <div class="row">
                <div class="col">
                    <input class="form-control mb-2" type="text" name="name" placeholder="Name" 
                    value="<?= isset($edit_pet) ? htmlspecialchars($edit_pet['Name']) : '' ?>" required>
                </div>
                <div class="col">
                    <select class="form-control mb-2" name="type" required>
                        <option value="">Type</option>
                        <option value="Dog" <?= isset($edit_pet) && $edit_pet['Type']=='Dog' ? 'selected' : '' ?>>Dog</option>
                        <option value="Cat" <?= isset($edit_pet) && $edit_pet['Type']=='Cat' ? 'selected' : '' ?>>Cat</option>
                        <option value="Other" <?= isset($edit_pet) && $edit_pet['Type']=='Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="col">
                    <input class="form-control mb-2" type="text" name="breed" placeholder="Breed"
                    value="<?= isset($edit_pet) ? htmlspecialchars($edit_pet['Breed']) : '' ?>">
                </div>
                <div class="col">
                    <input class="form-control mb-2" type="number" name="age" placeholder="Age"
                    value="<?= isset($edit_pet) ? $edit_pet['Age'] : '' ?>">
                </div>
                <div class="col">
                    <select class="form-control mb-2" name="sex">
                        <option value="">Sex</option>
                        <option value="Male" <?= isset($edit_pet) && $edit_pet['Sex']=='Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= isset($edit_pet) && $edit_pet['Sex']=='Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Unknown" <?= isset($edit_pet) && $edit_pet['Sex']=='Unknown' ? 'selected' : '' ?>>Unknown</option>
                    </select>
                </div>
            </div>
            <div class="mb-2">
                <input class="form-control" type="text" name="color" placeholder="Color" 
                value="<?= isset($edit_pet) ? htmlspecialchars($edit_pet['Color']) : '' ?>">
            </div>
            <div class="mb-2">
                <input class="form-control" type="text" name="size" placeholder="Size" 
                value="<?= isset($edit_pet) ? htmlspecialchars($edit_pet['Size']) : '' ?>">
            </div>
            <div class="mb-2">
                <textarea class="form-control" name="description" placeholder="Description"><?= isset($edit_pet) ? htmlspecialchars($edit_pet['Description']) : '' ?></textarea>
            </div>
            <div class="mb-2">
                <textarea class="form-control" name="requirements" placeholder="Adoption requirements"><?= isset($edit_pet) ? htmlspecialchars($edit_pet['adoption_requirements']) : '' ?></textarea>
            </div>
            <div class="mb-2">
                <input class="form-control" type="text" name="image" placeholder="Image URL (optional)" 
                value="<?= isset($edit_pet) ? htmlspecialchars($edit_pet['ImageUrl']) : '' ?>">
            </div>
            <button type="submit" name="<?= isset($edit_pet) ? 'update_pet' : 'add_pet' ?>" class="btn btn-primary">
                <?= isset($edit_pet) ? 'Update Pet' : 'Add Pet' ?>
            </button>
            <?php if(isset($edit_pet)): ?>
                <a href="pets.php" class="btn btn-secondary">Cancel</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- List all pets -->
<div class="row">
<?php while($pet = $pets->fetch_assoc()): ?>
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <img src="<?= htmlspecialchars($pet['ImageUrl']) ?>" class="card-img-top" alt="<?= htmlspecialchars($pet['Name']) ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($pet['Name']) ?> (<?= htmlspecialchars($pet['Type']) ?>)</h5>
                <p><strong>Breed:</strong> <?= htmlspecialchars($pet['Breed']) ?></p>
                <p><strong>Age:</strong> <?= $pet['Age'] ?> | <strong>Sex:</strong> <?= htmlspecialchars($pet['Sex']) ?></p>
                <p><?= substr($pet['Description'],0,100) ?>...</p>
                <p><strong>Requirements:</strong> <?= $pet['adoption_requirements'] ? substr($pet['adoption_requirements'],0,100) : 'No requirements specified'; ?></p>
                <a href="?delete=<?= $pet['ID'] ?>" class="btn btn-danger btn-sm">Delete</a>
                <a href="?edit=<?= $pet['ID'] ?>" class="btn btn-warning btn-sm">Edit</a>
            </div>
        </div>
    </div>
<?php endwhile; ?>
</div>

</div>
</body>
</html>
