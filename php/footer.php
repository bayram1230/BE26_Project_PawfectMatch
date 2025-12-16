<!-- footer.php -->
<footer class="bg-success text-white mt-5 p-4 w-100">
  <div class="container-fluid text-center">
    <div class="social-icons mb-3">
      <a href="#"><i class="fab fa-facebook-f text-white me-3"></i></a>
      <a href="#"><i class="fab fa-twitter text-white me-3"></i></a>
      <a href="#"><i class="fab fa-google text-white me-3"></i></a>
      <a href="#"><i class="fab fa-instagram text-white me-3"></i></a>
      <a href="#"><i class="fab fa-linkedin-in text-white me-3"></i></a>
      <a href="#"><i class="fab fa-github text-white"></i></a>
    </div>

    <!-- Newsletter -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['newsletter-email'])): ?>
      <div class="alert alert-light text-dark w-50 mx-auto mb-3">
        ✅ Subscription successful for <?php echo htmlspecialchars($_POST['newsletter-email']); ?>!
      </div>
    <?php endif; ?>

    <div class="newsletter mb-4">
      <form method="post" action="" class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
        <label for="newsletter-email" class="form-label mb-0">Sign up for our newsletter</label>
        <input type="email" name="newsletter-email" id="newsletter-email" class="form-control" placeholder="Enter your email" required>
        <button type="submit" class="btn btn-outline-light">Subscribe</button>
      </form>
    </div>

    <div class="links mb-3">
      <a href="contact.php" class="text-white me-3">Contact</a>
      <a href="about.php" class="text-white me-3">About</a>
      <a href="terms.php" class="text-white me-3">Terms & Conditions</a>
      <a href="privacy.php" class="text-white">Privacy Policy</a>
    </div>

    <div class="extras mb-3">
      <a href="resources.php" class="text-white me-3">Resource Library</a>
      <a href="stories.php" class="text-white me-3">Adoption Stories</a>
      <a href="pet_of_week.php" class="text-white me-3">Pet of the Week</a>
      <a href="volunteer.php" class="text-white">Volunteer Opportunities</a>
    </div>

    <div class="copyright">
      © 2025 PawfectMatch
    </div>
  </div>
</footer>
