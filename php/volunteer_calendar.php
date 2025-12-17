<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Volunteer Calendar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Shared CSS + Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link href="../css/style.css" rel="stylesheet">

  <style>
    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 1rem 0;
    }
    body {
      margin-bottom: 120px; /* prevent overlap with sticky footer */
    }
    .index-container {
      padding-bottom: 140px; /* extra space so footer doesn't block content */
    }
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
<body class="body-pic">
  <!-- Navbar -->
  

  <div class="container index-container mt-5">
    <h2 class="paw-card-h1 text-white text-center mb-3"
        style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
      📅 Volunteer Calendar
    </h2>
    <p class="lead text-white text-center mb-4" style="opacity: 0.9;">
      Calendar for PawfectMatch volunteer events — adoption fairs, walking shifts, and community activities.
    </p>

    <div class="calendar-container shadow p-3 bg-light rounded">
      <!-- Google Calendar embed -->
      <iframe src="https://calendar.google.com/calendar/embed?src=922354c191601167e6ff62bfe238fcc42613d2c0bf6608c6da75109d7b4efbb4%40group.calendar.google.com&ctz=Europe/Vienna" 
              frameborder="0" scrolling="no"></iframe>
    </div>
  </div>

  <!-- Footer -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
