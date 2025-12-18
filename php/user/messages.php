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
SELECT m.Message, m.ID, u.Username, u.Name, u.Email
FROM message m
JOIN users u ON m.Username = u.Username
JOIN adoptionhistory a ON a.Username = u.Username
WHERE a.Status = 'Approved'
AND u.Username = ?
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

    <style>
        .apple-card {
            background: rgba(255,255,255,0.95);
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            padding: 20px;
        }

        .message-box {
            max-height: 420px;
            overflow-y: auto;
            padding-right: 6px;
        }

        .message-item {
            background: #f5f5f7;
            border-radius: 14px;
            padding: 12px 16px;
            margin-bottom: 12px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
        }

        .message-user {
            font-weight: 600;
            color: #0b5ed7;
            margin-bottom: 4px;
        }

        .message-text {
            font-size: 15px;
            line-height: 1.6;
            color: #333;
        }

        .message-input {
            border-radius: 14px;
            padding: 14px;
            resize: none;
        }

        .send-btn {
            border-radius: 14px;
            font-weight: 600;
        }
    </style>
</head>

<body class="body-pic">

<?php require_once "../../components/navbar.php"; ?>
<?php require_once __DIR__ . "/user_menu.php"; ?>
<?php require_once __DIR__ . "/btn.php"; ?>

<div class="container my-5" style="max-width:800px;">


    <div class="apple-card mb-4">

        <h4 class="text-center mb-3">Messages</h4>

        <div class="message-box">

            <?php if (mysqli_num_rows($result) === 0): ?>
                <p class="text-center text-muted">No messages yet.</p>
            <?php else: ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="message-item">
                        <div class="message-user">
                            <?= htmlspecialchars($row['Username']) ?>
                        </div>
                        <div class="message-text">
                            <?= nl2br(htmlspecialchars($row['Message'])) ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

        </div>
    </div>

    <div class="apple-card">
        <form method="post">
            <textarea
                name="message"
                class="form-control message-input mb-3"
                rows="3"
                placeholder="Write your message..."
                required
            ></textarea>

            <button type="submit" name="send" class="btn btn-dark w-100 send-btn">
                Send Message
            </button>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>