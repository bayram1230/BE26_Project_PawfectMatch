<?php
session_start();

/** TEST-MODUS: role auswählen (user oder shelter) */
$role = isset($_GET["role"]) && $_GET["role"] === "shelter" ? "shelter" : "user";
$my_id = isset($_GET["id"]) ? (int)$_GET["id"] : 1;

require_once __DIR__ . "/../../components/db_connect.php";

if (!isset($conn) || !($conn instanceof mysqli)) {
    die("DB connection not found.");
}


/** Conversations laden */
if ($role === "user") {
  $stmt = $conn->prepare("
    SELECT c.id, c.created_at, c.shelter_id
    FROM conversations c
    WHERE c.user_id=?
    ORDER BY c.created_at DESC
  ");
} else {
  $stmt = $conn->prepare("
    SELECT c.id, c.created_at, c.user_id
    FROM conversations c
    WHERE c.shelter_id=?
    ORDER BY c.created_at DESC
  ");
}
$stmt->bind_param("i", $my_id);
$stmt->execute();
$convos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inbox</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="body-pic">
  <?php require_once "../../components/navbar.php"; ?>
  <main class="container contact-container">
    <div class="paw-card contact-card">
      <div class="paw-card-inner contact-inner">

        <h1 class="contact-title" style="font-size:42px;">Inbox</h1>
        <p class="contact-subtitle">
          Mode: <b><?php echo htmlspecialchars($role); ?></b> — ID: <b><?php echo (int)$my_id; ?></b>
        </p>

        <div class="mt-4">
          <?php if (empty($convos)): ?>
            <div class="alert alert-info text-center">No conversations yet.</div>
            <div class="text-center">
              <a class="btn contact-btn" style="max-width:380px;"
                 href="start.php?user_id=1&shelter_id=2">Start test conversation</a>
            </div>
          <?php else: ?>
            <div class="list-group">
              <?php foreach ($convos as $c): ?>
                <a class="list-group-item list-group-item-action"
                   href="chat.php?conversation_id=<?php echo (int)$c["id"]; ?>">
                  <div class="d-flex justify-content-between">
                    <div>
                      <b>Conversation #<?php echo (int)$c["id"]; ?></b>
                      <div class="small text-muted">
                        <?php
                          if ($role === "user") echo "Shelter ID: " . (int)$c["shelter_id"];
                          else echo "User ID: " . (int)$c["user_id"];
                        ?>
                      </div>
                    </div>
                    <div class="small text-muted"><?php echo htmlspecialchars($c["created_at"]); ?></div>
                  </div>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </main>
</body>
</html>

