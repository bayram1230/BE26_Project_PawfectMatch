<?php
session_start();

function back_error(string $msg): void {
  header("Location: contact.php?error=" . urlencode($msg));
  exit;
}

$first = trim($_POST["first_name"] ?? "");
$last  = trim($_POST["last_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$msg   = trim($_POST["message"] ?? "");

if ($first === "" || $last === "" || $email === "" || $msg === "") {
  back_error("Please fill in all required fields.");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  back_error("Please enter a valid email.");
}

/** DB CONNECT automatisch finden */
$possible = [
  __DIR__ . "/../../db_connect.php",
  __DIR__ . "/../db_connect.php",
  __DIR__ . "/../../php/db_connect.php",
];

foreach ($possible as $p) {
  if (file_exists($p)) {
    require_once $p;
    break;
  }
}

if (!isset($conn) || !($conn instanceof mysqli)) {
  back_error("Database connection not found (db_connect.php).");
}

$stmt = $conn->prepare("
  INSERT INTO contact_messages (first_name, last_name, email, phone, message)
  VALUES (?, ?, ?, ?, ?)
");

if (!$stmt) {
  back_error("DB prepare failed.");
}

$stmt->bind_param("sssss", $first, $last, $email, $phone, $msg);

if (!$stmt->execute()) {
  $stmt->close();
  back_error("DB insert failed.");
}

$stmt->close();

header("Location: contact.php?success=1");
exit;

