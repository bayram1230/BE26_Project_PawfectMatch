<?php
session_start();
require_once "components/db_connect.php";
require_once "components/profile_pic.php";



if (!isset($_SESSION["user"])) {
    header("Location:  php/login/login.php?restricted=true");
    exit;
}


if (!isset($_GET["id"])) {
    header("Location: pets.php");
    exit;
}

$animalId = $_GET["id"];
$username = $_SESSION["user"];
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
            INSERT INTO adoptionrequest (Username, AnimalID, SurveyAnswer)
            VALUES ('$username', '$animalId', '$surveyAnswer')
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link href="css/style.css" rel="stylesheet">
</head>
<body class="body-pic">

<?php 
include_once "navbar-user.php";
?> 

<div class="container my-5" style="max-width: 600px;">
    <h2 class="mb-4 text-center text-white">Adoption Application</h2>

    <?php if (isset($msg)): ?>
        <div class="alert alert-danger"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label text-white">Living situation *</label>
            <textarea name="living" class="form-control" rows="2"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label text-white">Previous pet ownership experience *</label>
            <textarea name="experience" class="form-control" rows="2"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label text-white">Reason for adopting *</label>
            <textarea name="reason" class="form-control" rows="2"></textarea>
            
        <div class="mb-3">

    <label class="form-label text-white">Daily routine & time availability</label>
    <textarea name="routine" class="form-control" rows="2"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label text-white">Household & allergies</label>
        <textarea name="allergies" class="form-control" rows="2"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label text-white">Financial readiness</label>
        <textarea name="financial" class="form-control" rows="2"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label text-white">Home environment</label>
        <textarea name="environment" class="form-control" rows="2"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label text-white">Animal preferences</label>
        <textarea name="preferences" class="form-control" rows="2"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label text-white">Additional notes</label>
        <textarea name="notes" class="form-control" rows="2"></textarea>
    </div>


        <button type="submit" name="apply" class="btn btn-success mt-3">
            Submit Application
        </button>

    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
