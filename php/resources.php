<?php
require_once __DIR__ . "/functions/db_connect.php";
require_once __DIR__ . "/functions/get_profile.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Resources</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + FontAwesome + Shared CSS -->
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
      margin-bottom: 100px; /* prevent overlap with sticky footer */
    }
    .index-container {
      padding-bottom: 140px; /* extra space so footer doesn't block content */
    }
  </style>
</head>
<body class="body-pic">
  <div class="container index-container mt-5">
    <h2 class="paw-card-h1 text-white text-center mb-3"
        style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
      📚 Resources for New Adopters
    </h2>
    <p class="lead text-white text-center mb-4" style="opacity: 0.9;">
      Expert tips and guides to make your adoption journey smooth, joyful, and successful.
    </p>

    <!-- Section 1 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>Preparing Your Home</h4>
        <ul>
          <li>Create a dedicated “safe zone” with a bed, blanket, and toys where your pet can retreat.</li>
          <li>Pet‑proof your home: secure trash cans, hide electrical cords, and remove choking hazards.</li>
          <li>Stock up on essentials: food, bowls, litter box (for cats), grooming supplies, and ID tags.</li>
          <li>Set up baby gates or playpens if you want to limit access to certain rooms at first.</li>
          <li>Introduce family members slowly — let your pet meet them one at a time in calm settings.</li>
        </ul>
      </div>
    </div>

    <!-- Section 2 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>First Days Together</h4>
        <ul>
          <li>Keep the schedule predictable: feed, walk, and play at the same times each day.</li>
          <li>Don’t rush introductions with other pets — use scent swapping and gradual meetings.</li>
          <li>Expect accidents or nervous behavior; patience and consistency are key.</li>
          <li>Use a crate or carrier as a safe den, not punishment — it helps with house training.</li>
          <li>Limit visitors during the adjustment period to reduce stress.</li>
        </ul>
      </div>
    </div>

    <!-- Section 3 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>Health & Care</h4>
        <ul>
          <li>Book a vet appointment within the first week to establish a health baseline.</li>
          <li>Ask about microchipping and register your pet’s ID immediately.</li>
          <li>Keep a folder with vaccination records, vet notes, and adoption paperwork.</li>
          <li>Learn basic first aid: how to check gums, trim nails, and recognize signs of distress.</li>
          <li>Establish a grooming routine early — brushing, bathing, dental care — so your pet gets used to it.</li>
        </ul>
      </div>
    </div>

    <!-- Section 4 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>Training & Bonding</h4>
        <ul>
          <li>Use short, positive training sessions (5–10 minutes) to keep your pet engaged.</li>
          <li>Reward desired behavior immediately with treats or praise — timing is everything.</li>
          <li>Enroll in a basic obedience or socialization class to build confidence.</li>
          <li>Play interactive games (fetch, hide‑and‑seek, puzzle toys) to strengthen your bond.</li>
          <li>Practice handling paws, ears, and mouth gently so vet visits and grooming are easier later.</li>
        </ul>
      </div>
    </div>

    <!-- Section 5 -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <h4>Long‑Term Happiness</h4>
        <ul>
          <li>Provide daily exercise tailored to breed and age — mental stimulation is just as important as physical.</li>
          <li>Rotate toys to keep things fresh and prevent boredom.</li>
          <li>Schedule annual vet checkups and dental cleanings.</li>
          <li>Celebrate milestones: adoption anniversaries, birthdays, and training achievements.</li>
          <li>Consider pet insurance to help with unexpected medical costs.</li>
          <li>Build a trusted support network: neighbors, pet sitters, or family who can help when needed.</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
