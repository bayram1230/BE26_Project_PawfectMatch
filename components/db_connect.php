<?php 

try {
$host="localhost";
$user="root";
$password="root";
$database="petadoption";

$conn = mysqli_connect($host, $user, $password, $database);
// echo "Database connected successfully";

} catch (mysqli_sql_exception $e) {
    echo"Connection error:". $e ->getMessage();
}