<?php
session_start();

require_once "../../components/db_connect.php";
require_once "../functions/user_restriction.php";

requireUser(); // only user allowed

$username = $_SESSION['username'] ?? null;

if (!$username) {
    die("User not found.");
}

/* SUCCESS ALERT */
if (isset($_GET['sent']) && $_GET['sent'] == 1) {
    echo "<script>alert('Message sent successfully.');</script>";
}

/* LOAD MESSAGES (only APPROVED) */
$sql = "
SELECT m.*
FROM message m
JOIN adoptionhistory a ON m.Username = a.Username
WHERE a.Status = 'Approved'
AND m.Username = ?
ORDER BY m.ID ASC
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

/* SEND MESSAGE */
if (isset($_POST['send'])) {
    $msg = trim($_POST['message']);

    if ($msg !== "") {
        $sqlInsert = "
            INSERT INTO message (Username, Message)
            VALUES (?, ?)
        ";
        $stmtInsert = mysqli_prepare($conn, $sqlInsert);
        mysqli_stmt_bind_param($stmtInsert, "ss", $username, $msg);
        mysqli_stmt_execute($stmtInsert);

        header("Location: messages.php?sent=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="body-pic">

<?php require_once "../../components/navbar.php"; ?>

<div class="container my-5" style="max-width:800px;">
    <h2 class="text-center mb-4 text-white">Messages</h2>

    <div class="card p-3 mb-4" style="max-height:400px; overflow-y:auto;">
        <?php if (mysqli_num_rows($result) === 0): ?>
            <p class="text-center">No messages yet.</p>
        <?php else: ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="mb-2">
                    <strong><?= htmlspecialchars($row['Username']) ?>:</strong><br>
                    <?= nl2br(htmlspecialchars($row['Message'])) ?>
                </div>
                <hr>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <form method="post">
        <textarea
            name="message"
            class="form-control mb-2"
            rows="3"
            placeholder="Write your message..."
            required
        ></textarea>

        <button type="submit" name="send" class="btn btn-dark w-100">
            Send Message
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
