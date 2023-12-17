<!-- Navbar Large screens -->
<nav class="navbar navbar-expand-lg sticky-top flex-column py-0 d-none d-lg-block">
  <div class="container-fluid px-0 py-2">
    <!-- Logo -->
    <a class="navbar-brand pt-0 mx-5" href="/">
      <img src="images/logo-small.svg" alt="Sixth" width="60px">
    </a>
    <!-- Search Bar -->

    <!-- Links & Buttons -->
    <ul class="navbar-nav ms-auto justify-content-center" style="font-weight: 500;">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-sixth-beige" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categorieen
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Categorie 1</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Categorie 2</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Categorie 3</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link text-sixth-beige" href="#">Service</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-sixth-beige" href="#">Overig</a>
      </li>
      <li class="nav-item mx-3">
        <button class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center nav-button">
          <img src="images/account-icon.png" alt="Account" width="17" height="17">
        </button>
      </li>
      <li class="nav-item me-5">
        <button class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center nav-button">
          <img src="images/basket-icon.png" alt="Mand" width="17" height="17">
        </button>
      </li>
    </ul>
  </div>

  <!-- KPI Bar -->
  <div class="container-fluid kpi-bar"></div>

</nav>

<!-- Navbar Mobile -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top flex-column py-0 d-lg-none" style="background-color:var(--sixth-brown) !important;">
  <div class="container-fluid px-0 pt-3">
    <!-- Logo and Search Bar on the left -->
    <a class="navbar-brand pt-0 mx-3" href="#">
      <img src="images/Logo_Small.svg" alt="Your Logo">
    </a>
    <div class="d-flex ms-auto">
      <button class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="background-color: var(--sixth-yellow);border-color: var(--sixth-yellow); width: 40px; height: 40px;">
        <img src="images/account-icon.png" alt="Account" width="17" height="17">
      </button>
      <button class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" style="background-color: var(--sixth-yellow);border-color: var(--sixth-yellow); width: 40px; height: 40px;">
        <img src="images/basket-icon.png" alt="Mand" width="17" height="17">
      </button>
    </div>
    <!-- Hamburger Menu Button -->
    <button class="navbar-toggler mx-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Links and Buttons on the right -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto justify-content-center" style="font-weight: 500;">
        <li class="nav-item dropdown">
          <!-- Added dropdown class to the list item -->
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: var(--sixth-beige)" ;>
            Categorieen
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" style="color: var(--sixth-beige)">Service</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" style="color: var(--sixth-beige)">Overig</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Search Bar -->
  <div class="container-fluid px-3 my-3 justify-content-center align-items-center">
    <div class="input-group">
      <input class="custom-form-control rounded-pill" type="search" placeholder="Zoek een product" aria-label="Search">
    </div>
  </div>

  <!-- KPI Bar -->
  <div class="container-fluid" style="height: 15px; background-color: var(--sixth-yellow);"></div>

</nav>

