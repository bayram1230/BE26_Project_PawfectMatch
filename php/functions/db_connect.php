<?php
$host = "localhost";
$user = "root";
$pass = "";       // MAMP: "root"
$dbname = "PetAdoption";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
