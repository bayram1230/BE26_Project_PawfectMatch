<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- Navbar OUTSIDE container -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2 class="mt-4">📞 Contact Us</h2>
    <p class="lead">We’d love to hear from you! Reach out using the details below:</p>

    <div class="card shadow w-50 mx-auto mb-4">
      <div class="card-body text-center">
        <p><strong>Email:</strong> <a href="mailto:info@pawfectmatch.com">info@pawfectmatch.com</a></p>
        <p><strong>Phone:</strong> <a href="tel:+43123456789">+43 123 456 789</a></p>
      </div>
    </div>

    <!-- Contact Form -->
    <form id="contactForm" class="w-50 mx-auto">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" required>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" rows="4" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Send</button>
    </form>

    <!-- Success message -->
    <div id="successMessage" class="alert alert-success mt-3 w-50 mx-auto" style="display:none;">
      ✅ Submission sent!
    </div>
  </div>

  <!-- Footer OUTSIDE container -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Script at the very end -->
  <script>
    window.onload = function() {
      const form = document.getElementById('contactForm');
      const successMessage = document.getElementById('successMessage');

      form.onsubmit = function(e) {
        e.preventDefault(); // stop page refresh
        successMessage.style.display = 'block'; // show message
      };
    };
  </script>

  <!-- Bootstrap JS bundle for dropdowns -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
