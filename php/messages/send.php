<?php
session_start();

$conversation_id = isset($_POST["conversation_id"]) ? (int)$_POST["conversation_id"] : 0;
$sender_role     = isset($_POST["sender_role"]) && $_POST["sender_role"] === "shelter" ? "shelter" : "user";
$body            = trim($_POST["body"] ?? "");

if ($conversation_id <= 0 || $body === "") {
  header("Location: inbox.php");
  exit;
}

require_once __DIR__ . "/../../components/db_connect.php";

if (!isset($conn) || !($conn instanceof mysqli)) {
    die("DB connection not found.");
}


$stmt = $conn->prepare("INSERT INTO messages (conversation_id, sender_role, body) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $conversation_id, $sender_role, $body);
$stmt->execute();
$stmt->close();

header("Location: chat.php?conversation_id=" . $conversation_id . "&as=" . $sender_role);
exit;
