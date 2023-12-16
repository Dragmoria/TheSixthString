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

  .mt-custom {
    margin-top: 10rem !important;
  }

  .mb-custom {
    margin-bottom: 10rem !important;
  }

  .ms-custom {
    padding-right: 25rem !important;
  }

  .me-custom {
    padding-left: 25rem !important;
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
<?
$randomLink =""
?>


<div class="container d-flex mb-5 mt-5 justify-content-center">
  <div class="card p-1 bg-card-custom w-40 d-inline-block">
    <form method="POST" action="/sendEmail<?echo $randomLink ?>">
      <div class="ms-5 me-5 mt-3">
        <h1 style="color:#EFE3C4">Wachtwoord herstellen</h1>
      </div>
      <div class="col-auto ms-5 me-5 mb-4 mt-5">
        <div class="row">
          <input type="form-check-text" class="form-control custom-input-height bg-beige-color" id="email" name="email"
            placeholder="E-mailadres" required></input>
        </div>
      </div>
      <div class="col-auto ms-5 me-5 mb-4 mt-2">
        <div class="row">
            <button type="submit" id="sendEmail" name="sendEmail"
              class="btn btn-primary rounded-pill form-check bg-beige-color"
              style="width: max-content;background-color:#FCB716;border-color:#FCB716">Wachtwoord herstellen</button>
        </div>
    </form>
  </div>
</div>