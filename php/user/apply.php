<?php
session_start();
require_once "../../components/db_connect.php";
require_once "../functions/get_profile.php";



if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login/login.php?restricted=true");
    exit;
}



if (!isset($_GET["id"])) {
    header("Location: pets.php");
    exit;
}

$animalId = (int) $_GET["id"];
$userId   = (int) $_SESSION['user_id'];
$username = $_SESSION['username'];
$error = false;

// wenn formular abgeschickt wird
if (isset($_POST["apply"])) {
    $living = trim($_POST["living"]);
    $experience = trim($_POST["experience"]);
    $reason = trim($_POST["reason"]);
    $routine = trim($_POST["routine"]);
    $allergies = trim($_POST["allergies"]);
    $financial = trim($_POST["financial"]);
    $environment = trim($_POST["environment"]);
    $preferences = trim($_POST["preferences"]);
    $notes = trim($_POST["notes"]);



    // es muss mind. living, experience und reason ausgefüllt sein
    if (empty($living) || empty($experience) || empty($reason)) {
        $error = true;
        $msg = "All fields are required.";
    }

    // wenn kein Fehler, Daten in DB speichern
    if (!$error) {
        $surveyAnswer =
             "Living situation: $living\n" .
            "Experience with animals: $experience\n" .
            "Daily routine & time availability: $routine\n" .
            "Household & allergies: $allergies\n" .
            "Reason for adoption: $reason\n" .
            "Financial readiness: $financial\n" .
            "Home environment: $environment\n" .
            "Animal preferences: $preferences\n" .
            "Additional notes: $notes";

        $sql = "
     INSERT INTO adoptionrequest (Username, AnimalID, SurveyAnswer, user_id)
      VALUES ('$username', '$animalId', '$surveyAnswer', '$userId')
        ";

        if (mysqli_query($conn, $sql)) {
            header("Location: my_applications.php");
            exit;
        } else {
            $msg = "Something went wrong.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Adoption</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">

    <style>
        .register-card {
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            background: #9affb4;
        }
        .register-card textarea {
            border-radius: 8px;
        }
        .register-btn {
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>

<body class="body-pic">

<?php require_once "../../components/navbar.php"; ?>
<?php require_once __DIR__ . "/user_menu.php"; ?>
<?php require_once __DIR__ . "/btn.php"; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8">

            <div class="card register-card p-4">

                <h4 class="text-center mb-4">Adoption Application</h4>

                <?php if (isset($msg)): ?>
                    <div class="alert alert-danger"><?= $msg ?></div>
                <?php endif; ?>

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label">Living situation *</label>
                        <textarea name="living" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Previous pet ownership experience *</label>
                        <textarea name="experience" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reason for adopting *</label>
                        <textarea name="reason" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Daily routine & time availability</label>
                        <textarea name="routine" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Household & allergies</label>
                        <textarea name="allergies" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Financial readiness</label>
                        <textarea name="financial" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Home environment</label>
                        <textarea name="environment" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Animal preferences</label>
                        <textarea name="preferences" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Additional notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>

                    <button type="submit" name="apply" class="btn btn-dark w-100 register-btn mt-3">
                        Submit Application
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
