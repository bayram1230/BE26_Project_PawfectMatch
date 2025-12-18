<?php
session_start();

$conversation_id = isset($_GET["conversation_id"]) ? (int)$_GET["conversation_id"] : 0;
if ($conversation_id <= 0) die("Missing conversation_id.");

/** TEST-MODUS: sender_role wechseln */
$sender_role = (isset($_GET["as"]) && $_GET["as"] === "shelter") ? "shelter" : "user";

require_once __DIR__ . "/../../components/db_connect.php";

if (!isset($conn) || !($conn instanceof mysqli)) {
    die("DB connection not found.");
}


/** Messages laden */
$stmt = $conn->prepare("
  SELECT sender_role, body, created_at
  FROM messages
  WHERE conversation_id=?
  ORDER BY created_at ASC, id ASC
");
$stmt->bind_param("i", $conversation_id);
$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/style.css">
  <style>
    .chat-box { max-width: 760px; margin: 0 auto; }
    .bubble { padding: 12px 14px; border-radius: 14px; margin: 10px 0; max-width: 80%; }
    .bubble-user { background: rgba(255,255,255,0.95); margin-left: auto; }
    .bubble-shelter { background: rgba(15,0,90,0.10); margin-right: auto; }
    .bubble-meta { font-size: 12px; opacity: 0.7; margin-top: 6px; }
  </style>
</head>
<body class="body-pic">
  <main class="container contact-container">
    <div class="paw-card contact-card chat-box">
      <div class="paw-card-inner contact-inner">

        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h1 class="contact-title" style="font-size:40px;margin:0;">Chat</h1>
            <div class="contact-subtitle">
              Conversation #<?php echo (int)$conversation_id; ?> —
              sending as <b><?php echo htmlspecialchars($sender_role); ?></b>
            </div>
          </div>
          <div class="text-end">
            <a class="btn btn-sm btn-outline-dark" href="inbox.php">Inbox</a><br>
            <a class="btn btn-sm btn-outline-dark mt-2"
               href="chat.php?conversation_id=<?php echo (int)$conversation_id; ?>&as=user">As user</a>
            <a class="btn btn-sm btn-outline-dark mt-2"
               href="chat.php?conversation_id=<?php echo (int)$conversation_id; ?>&as=shelter">As shelter</a>
          </div>
        </div>

        <hr>

        <div style="max-height: 420px; overflow:auto; padding-right:8px;">
          <?php if (empty($rows)): ?>
            <div class="alert alert-info text-center">No messages yet. Write the first one 👇</div>
          <?php endif; ?>

          <?php foreach ($rows as $m): ?>
            <?php $isUser = ($m["sender_role"] === "user"); ?>
            <div class="bubble <?php echo $isUser ? "bubble-user" : "bubble-shelter"; ?>">
              <div><?php echo nl2br(htmlspecialchars($m["body"])); ?></div>
              <div class="bubble-meta">
                <?php echo htmlspecialchars($m["sender_role"]); ?> • <?php echo htmlspecialchars($m["created_at"]); ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <form action="send.php" method="POST" class="mt-3">
          <input type="hidden" name="conversation_id" value="<?php echo (int)$conversation_id; ?>">
          <input type="hidden" name="sender_role" value="<?php echo htmlspecialchars($sender_role); ?>">

          <textarea name="body" class="form-control contact-textarea" rows="3" placeholder="Type your message..." required></textarea>
          <button class="btn contact-btn mt-3" type="submit">Send</button>
        </form>

      </div>
    </div>
  </main>
</body>
</html>

