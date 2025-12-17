<?php
// footer.php
// Newsletter subscription logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['newsletter-email'])) {
    $subscriptionMessage = "✅ Subscription successful for " . htmlspecialchars($_POST['newsletter-email']) . "!";
}
?>
<footer>
  <div class="container-fluid text-center">
    <!-- Social Icons -->
    <div class="social-icons mb-3">
      <a href="#"><i class="fab fa-facebook-f me-3"></i></a>
      <a href="#"><i class="fab fa-twitter me-3"></i></a>
      <a href="#"><i class="fab fa-google me-3"></i></a>
      <a href="#"><i class="fab fa-instagram me-3"></i></a>
      <a href="#"><i class="fab fa-linkedin-in me-3"></i></a>
      <a href="#"><i class="fab fa-github"></i></a>
    </div>

    <!-- Newsletter -->
    <?php if (!empty($subscriptionMessage)): ?>
      <div class="alert alert-light text-dark w-50 mx-auto mb-3">
        <?= $subscriptionMessage ?>
      </div>
    <?php endif; ?>

    <div class="newsletter mb-4">
      <form method="post" action="" class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
        <label for="newsletter-email" class="form-label footer-info mb-0">Sign up for our newsletter</label>
        <input type="email" name="newsletter-email" id="newsletter-email"
               class="form-control newsletter-sign-up-box"
               placeholder="Enter your email" required>
        <button type="submit" class="btn subscribe">Subscribe</button>
      </form>
    </div>

    <!-- Standard Links (group-wide placeholders) -->
    <div class="mb-3">
      <a href="/pawfectmatch/php/contact.php" class="me-3 footer-info">Contact</a>
      <a href="/pawfectmatch/php/about.php" class="me-3 footer-info">About</a>
      <a href="/pawfectmatch/php/terms.php" class="me-3 footer-info">Terms & Conditions</a>
      <a href="/pawfectmatch/php/privacy.php" class="footer-info">Privacy Policy</a>
    </div>

    <!-- Extra Links (your deliverables) -->
    <div class="mb-3">
      <a href="/pawfectmatch/php/resources.php" class="me-3 footer-info">Resource Library</a>
      <a href="/pawfectmatch/php/stories.php" class="me-3 footer-info">Adoption Stories</a>
      <a href="/pawfectmatch/php/pet_of_week.php" class="me-3 footer-info">Pet of the Week</a>
      <a href="/pawfectmatch/php/pet_of_day.php" class="me-3 footer-info">Pet of the Day</a>
      <a href="/pawfectmatch/php/adopted_pets.php" class="me-3 footer-info">Adopted Pets</a>
      <a href="/pawfectmatch/php/fostered_pets.php" class="me-3 footer-info">Fostered Pets</a>
      <a href="/pawfectmatch/php/volunteer.php" class="me-3 footer-info">Volunteer Opportunities</a>
      <a href="/pawfectmatch/php/volunteer_calendar.php" class="me-3 footer-info">Volunteer Calendar</a>
      <a href="/pawfectmatch/php/matchmaker.php" class="footer-info">Matchmaker</a>
    </div>

    <!-- Copyright -->
    <div class="copyright footer-info">
      © 2025 PawfectMatch
    </div>
  </div>
</footer>
