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


  .line-hyper {
    content: "";
    display: block;
    width: calc(10 * 0.9 * 1em);
    max-width: 100%;
    border-bottom: 0.1em solid #EFE3C4;
    margin-left: 7.2rem;

  }
</style>
<?
$randomLink = ""
  ?>


<div class="container d-flex mb-5 mt-5 justify-content-center vh-100">
  <div class="card p-1 bg-card-custom w-40">
    <form id="ForgotPasswordForm" method="POST" action="/wachtwoord-vergeten/sent" onsubmit="handleFormSubmission(event)">
      <div class="ms-5 me-5 mt-3">
        <h1 style="color:#EFE3C4">Wachtwoord herstellen</h1>
      </div>
      <div class="col-auto ms-5 me-5 mb-4 mt-5">
        <div class="row">
          <input type="text" class="form-control custom-input-height bg-beige-color" id="email" name="email"
            placeholder="E-mailadres" required>
        </div>
      </div>
      <div class="mb-4 mt-2 text-center">
        <button type="submit" id="sendEmail" name="sendEmail"
          class="btn btn-primary rounded-pill form-check bg-beige-color mx-auto"
          style="background-color:#FCB716;border-color:#FCB716">Wachtwoord herstellen</button>
      </div>
    </form>

    <!-- Success message div -->
    <div class="d-flex justify-content-center col-auto mt- 5 ms-3 me-3">
      <div id="successMessage" class="text-center text-start" style="display: none; color: green;">
        <i class="bi bi-check-circle" style="font-size: 5em;color:#FCB716"></i>
        <p class="mt-3" style="color:#EFE3C4">We hebben je een e-mail gestuurd met <br> daarin een persoonlijke link.
          <br> Via deze link kun je een nieuw wachtwoord opgeven.
          <br> <br> Je ontvangt de mail binnen enkele minuten.<br> Of bekijk je spam inbox.
        </p>
        <a href="/Login" class="text-decoration-none" style="color:#EFE3C4">Terug naar inloggen</a>
        <div class="mb-5 line-hyper"></div>
      </div>
    </div>
  </div>
</div>

<script>

  function handleFormSubmission(event) {
    event.preventDefault(); 

    $.ajax({
      url: "/CreateRandomURL",
      type: "POST",
      data: $("#ForgotPasswordForm").serialize(),
      success: function (response) {
        document.getElementById('successMessage').style.display = 'block';
        document.getElementById('ForgotPasswordForm').style.display = 'none';
      },
      error: function (xhr, status, error) {
        console.error(xhr);
        console.error(status);
      }
    });
  }


</script>