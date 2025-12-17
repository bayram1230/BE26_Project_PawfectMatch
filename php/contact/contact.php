<?php
session_start();

$success = isset($_GET["success"]) && $_GET["success"] === "1";
$error   = isset($_GET["error"]) ? $_GET["error"] : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

  <!-- WICHTIG: du bist in php/contact/ -> 2 Ebenen hoch zur css -->
  <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="body-pic">

  <main class="container contact-container">
    <div class="paw-card contact-card">
      <div class="paw-card-inner contact-inner">

        <div class="contact-head">
          <h1 class="contact-title">Contact Us</h1>
          <p class="contact-subtitle">We will get back to you asap!</p>
        </div>

        <?php if ($success): ?>
          <div class="alert alert-success text-center contact-alert">
            Message sent successfully ✅
          </div>
        <?php elseif (!empty($error)): ?>
          <div class="alert alert-danger text-center contact-alert">
            <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <!-- WICHTIG: contact_send.php liegt im gleichen Ordner -->
        <form action="contact_send.php" method="POST" class="contact-form">
          <div class="row g-3">

            <div class="col-md-6">
              <div class="input-group contact-input-group">
                <span class="input-group-text contact-icon"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="first_name" class="form-control contact-input" placeholder="First Name" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group contact-input-group">
                <span class="input-group-text contact-icon"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="last_name" class="form-control contact-input" placeholder="Last Name" required>
              </div>
            </div>

            <div class="col-12">
              <div class="input-group contact-input-group">
                <span class="input-group-text contact-icon"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" name="email" class="form-control contact-input" placeholder="Email" required>
              </div>
            </div>

            <div class="col-12">
              <div class="input-group contact-input-group">
                <span class="input-group-text contact-icon"><i class="fa-solid fa-phone"></i></span>
                <input type="text" name="phone" class="form-control contact-input" placeholder="Phone">
              </div>
            </div>

            <div class="col-12">
              <textarea name="message" class="form-control contact-textarea" rows="5" placeholder="Your message..." required></textarea>
            </div>

            <div class="col-12">
              <button type="submit" class="btn contact-btn">Send</button>
            </div>

          </div>
        </form>

        <p class="contact-bottom">You may also call us at <span>333-33-33</span></p>

      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
