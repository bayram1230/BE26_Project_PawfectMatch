<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Volunteer Calendar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .calendar-container {
      max-width: 900px;
      margin: 0 auto;
    }
    iframe {
      border: 0;
      width: 100%;
      height: 600px;
    }
  </style>
</head>
<body>
  <!-- Navbar OUTSIDE container -->
  <?php include __DIR__ . '/navbar.php'; ?>

  <div class="container mt-5">
    <h2 class="mt-4">📅 Volunteer Calendar</h2>
    <p class="lead">Calendar for PawfectMatch volunteer events — adoption fairs, walking shifts, and community activities.</p>

    <div class="calendar-container shadow p-3 bg-light rounded">
      <!-- Google Calendar embed -->
      <iframe src="https://calendar.google.com/calendar/embed?src=922354c191601167e6ff62bfe238fcc42613d2c0bf6608c6da75109d7b4efbb4%40group.calendar.google.com&ctz=Europe/Vienna" 
              width="100%" height="600" frameborder="0" scrolling="no"></iframe>
    </div>
  </div>

  <!-- Footer OUTSIDE container -->
  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
