<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<style>
  body {
    background-color: #2C231E;
  }

  .bg-beige-color {
    background-color: #EFE3C4;
    border-color: #EFE3C4
  }

  .bg-beige-color:focus,
  select:focus {
    border-color: #FCB716;
    box-shadow: 0 0 0 0.2rem #FCB716;

  }

  .bg-card-custom {
    background-color: #1C1713;
  }

  .custom-input-height {
    height: calc(3.5 * 1em);
    /* Adjust the multiplier as needed */
  }


  .line-hyper {
    content: "";
    display: block;
    width: calc(10 * 1.05 * 1em);
    max-width: 100%;
    border-bottom: 0.1em solid #EFE3C4;
    margin-left: 4.5rem;

  }

  .password-container {
        position: relative;

    }

    .password-input {}

    .toggle-eye {
        position: absolute;
        top: 50%;
        left: 192px;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>


<div class="container d-flex mb-5 mt-5 justify-content-center">
  <div class="card p-1 bg-card-custom w-40 d-inline-block">
    <form method="POST" action="/Account">
      <input hidden name="_method" value="PUT"/>
      <div class="ms-5 mt-3">
        <h2 style="color:#EFE3C4">Sixth</h2>
        <h1 style="color:#EFE3C4">Inloggen</h1>
      </div>
      <div class="col-auto ms-5 me-5 mb-4 mt-5">
        <div class="row">
          <input type="form-check-text" class="form-control custom-input-height bg-beige-color" id="email" value="<?php echo htmlspecialchars($oldValueEmail ?? ''); ?>" name="email"
            placeholder="E-mailadres" required></input>
        </div>
      </div>
      <div class="password-container col-auto ms-5 me-5 mb-2 mt-2">
        <div class="row">
            <input type="password" class="form-control custom-input-height bg-beige-color password-input" value="<?php echo htmlspecialchars($oldValuePassword ?? ''); ?>" id="password"
              name="password" placeholder="Wachtwoord" required>
            <i class="bs bi-eye-slash-fill toggle-eye" onclick="togglePasswordVisibility('password')"></i>
        </div>
      </div>
      <div class="col-auto mt-1 me-1">
        <div class="row">
          <div class="col-12 mb-5 text-center">
            <a href="/wachtwoord-vergeten" class="text-decoration-none" style="color:#EFE3C4">Wachtwoord vergeten?</a>
            <div class="line-hyper"></div>
          </div>
        </div>
      </div>
      <div class="col-12 ms-5 mb-5 me-5 form">
        <div class="row">
          <div class="col-auto">
            <a href="/Register" id="registerButton" name="registerButton"
              class="btn btn-primary rounded-pill form-check bg-beige-color"
              style="width: min-content;background-color:#FCB716;border-color:#FCB716" value="Register">Registreren</a>
          </div>
          <div class="col-auto">
            <button type="submit" id="loginButton" name="loginButton"
              class="btn btn-primary rounded-pill form-check bg-beige-color"
              style="width: min-content;background-color:#FCB716;border-color:#FCB716" value="Login">Inloggen</button>
          </div>
        </div>
    </form>
  </div>
</div>




<script>



  document.addEventListener('DOMContentLoaded', function () {
    // Get the password input elements
    var passwordInputs = document.querySelectorAll('.password-input');

    // Add input event listeners to all password fields
    passwordInputs.forEach(function (passwordInput) {
      // Get the associated eye icon element
      var eyeIcon = passwordInput.parentElement.querySelector('.toggle-eye');
      eyeIcon.style.display = 'none';

      // Add an input event listener to the password field
      passwordInput.addEventListener('input', function () {
        // Toggle the eye icon visibility based on whether there is input in the password field
        eyeIcon.style.display = passwordInput.value.trim() !== '' ? 'block' : 'none';
      });

      // Add mouse event listeners to the eye icon for toggling password visibility
      eyeIcon.addEventListener('mousedown', function () {
        togglePasswordVisibility(passwordInput.id);
      });
    });
  });


  function togglePasswordVisibility(passwordName) {
    var passwordInput = document.getElementById(passwordName);


    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
    } else {
      passwordInput.type = 'password';
    }
  }


</script>