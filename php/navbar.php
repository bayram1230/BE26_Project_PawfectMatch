<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">PawfectMatch</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav">

        <!-- Adoption Category -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="adoptionDropdown" role="button" data-bs-toggle="dropdown">
            Adoption
          </a>
          <ul class="dropdown-menu">
            <!-- Point to index.php instead of available_pets.php -->
            <li><a class="dropdown-item" href="index.php">Available Pets</a></li>
            <li><a class="dropdown-item" href="fostered_pets.php">Fostered Pets</a></li>
            <li><a class="dropdown-item" href="adopted_pets.php">Adopted Pets</a></li>
            <li><a class="dropdown-item" href="pet_of_week.php">Pet of the Week</a></li>
          </ul>
        </li>

        <!-- Info Category -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-bs-toggle="dropdown">
            Info
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="resources.php">Resource Library</a></li>
            <li><a class="dropdown-item" href="stories.php">Adoption Stories</a></li>
            <li><a class="dropdown-item" href="volunteer.php">Volunteer Opportunities</a></li>
          </ul>
        </li>

        <!-- Legal Category -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="legalDropdown" role="button" data-bs-toggle="dropdown">
            Legal
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="terms.php">Terms & Conditions</a></li>
            <li><a class="dropdown-item" href="privacy.php">Privacy Policy</a></li>
          </ul>
        </li>

        <!-- Contact -->
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
