<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../components/db_connect.php';
require_once __DIR__ . '/../functions/get_profile.php';






$user_id   = isset($_GET["user_id"]) ? (int)$_GET["user_id"] : 1;
$shelter_id = isset($_GET["shelter_id"]) ? (int)$_GET["shelter_id"] : 2;


if (!isset($conn) || !($conn instanceof mysqli)) {
    die("DB connection not found.");
}


/** Conversation holen oder erstellen */
$stmt = $conn->prepare("SELECT id FROM conversations WHERE user_id=? AND shelter_id=?");
$stmt->bind_param("ii", $user_id, $shelter_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if ($row) {
  $conversation_id = (int)$row["id"];
} else {
  $stmt = $conn->prepare("INSERT INTO conversations (user_id, shelter_id) VALUES (?, ?)");
  $stmt->bind_param("ii", $user_id, $shelter_id);
  $stmt->execute();
  $conversation_id = $stmt->insert_id;
  $stmt->close();
}

header("Location: chat.php?conversation_id=" . $conversation_id);
exit;

