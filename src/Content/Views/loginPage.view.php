<style>
  p {
    font-size: 0.700em;
    /* 14px/16=0.875em */
  }

  .bg-beige-color {
    background-color: var(--sixth-white);
    border-color: var(--sixth-white);
  }

  .bg-beige-color:focus,
  select:focus {
    border-color: var(--sixth-yellow);
    box-shadow: 0 0 0 0.2rem var(--sixth-brown);

  }

  .card-custom {
    background-color: var(--sixth-black);
    border-radius: 2rem;
    min-width: 500px;
    max-width: 35vw;
  }

  .custom-input-height {
    height: calc(3.5 * 1em);
    /* Adjust the multiplier as needed */
  }


  .line-hyper {
    content: "";
    width: calc(10 * 1.05 * 1em);
    max-width: 100%;
    border-bottom: 0.1em solid #EFE3C4;

  }

  .password-container {
    position: relative;

  }

  .toggle-eye {
    position: absolute;
    top: 50%;
    left: 192px;
    transform: translateY(-50%);
    cursor: pointer;
  }
</style>
<div class="container vh-100 d-flex justify-content-center align-items-center">
  <div class="card p-1 card-custom mt-5">
    <form method="POST" action="/Account">
      <input hidden name="_method" value="PUT" />
      <div class="mx-5 mt-5">
        <img src="/images/logo-small-beige.svg" alt="Sixth" width="60px">
        <h1 style="color:#EFE3C4">Inloggen</h1>
      </div>
      <div class="ms-5 mt-5">
        <b>
          <p style="color:#FF0000;display: <?
          echo $error ?? "none";
          ?>;">ongeldig emailadres of
            wachtwoord</p>
        </b>
      </div>
      <div class="col-auto ms-5 me-5 mb-4 mt-3">
        <div class="row">
          <input type="form-check-text" class="form-control custom-input-height bg-beige-color" id="email"
            value="<?php echo htmlspecialchars($oldValueEmail ?? ''); ?>" name="email" placeholder="E-mailadres"
            required></input>
        </div>
      </div>
      <div class="password-container col-auto ms-5 me-5 mb-2 mt-2">
        <div class="row">
          <input type="password" class="form-control custom-input-height bg-beige-color password-input"
            value="<?php echo htmlspecialchars($oldValuePassword ?? ''); ?>" id="password" name="password"
            placeholder="Wachtwoord" required>
          <i class="bs bi-eye-slash-fill toggle-eye" onclick="togglePasswordVisibility('password')"></i>
        </div>
      </div>
      <div class="row my-5 flex-column align-items-center text-center">
        <a href="/ForgotPassword" class="text-decoration-none" style="color:#EFE3C4">Wachtwoord vergeten?</a>
        <div class="line-hyper"></div>
      </div>
      <div class="row mb-5">
        <div class="col"></div>
        <div class="col d-flex justify-content-center align-items-center">
          <a href="/Register" id="registerButton" class="btn btn-primary form-check fw-bold"
            style="width: min-content; background-color:var(--sixth-yellow); border-color:var(--sixth-yellow); color: var(--sixth-black);" value="Register">Registreren</a>
        </div>
        <div class="col d-flex justify-content-center align-items-center">
          <button type="submit" id="loginButton" class="btn btn-primary form-check fw-bold"
            style="width: min-content; background-color:var(--sixth-yellow); border-color:var(--sixth-yellow); color: var(--sixth-black);" value="Login">Inloggen</button>
        </div>
        <div class="col"></div>
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