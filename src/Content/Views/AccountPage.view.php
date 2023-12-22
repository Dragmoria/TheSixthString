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
      <div class="ms-5 mt-3">
        <h1 style="color:#EFE3C4">Account Page</h1>
        </div>
        <div class="col-auto">
            <button type="submit" id="logoutButton" 
              class="btn btn-primary rounded-pill form-check bg-beige-color"
              style="width: min-content;background-color:#FCB716;border-color:#FCB716" name="logoutButton">Uitloggen</button>
          </div>
    </form>
  </div>
</div>



