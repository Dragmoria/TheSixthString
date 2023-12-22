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

<?
$user = $_SESSION["user"]["firstname"];
?>







<div id="accountPageContainer" class="container-fluid col-12 d-flex mb-5 mt-4 justify-content-center">
  <form id="accountForm" method="POST" action="/Account">
    <div class="row">
      <div class="col-11 ms-3 mb-4 text-center">
        <h1 style=color:#EFE3C4>Mijn Account</h1>
      </div>
      <div class="row">
        <div class="col-2 ms-5">
          <button type="submit" id="logoutButton" class="btn btn-primary bg-beige-color w-100"
            style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Uitloggen</button>
          <button type="button" id="logoutButton" class=" mt-3 btn btn-primary bg-beige-color w-100"
            style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Persoonlijke gegevens</button>
          <button type="button" id="logoutButton" class="mt-3 btn btn-primary bg-beige-color w-100"
            style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Bestelgeschiedenis</button>
          <button type="button" id="logoutButton" class=" mt-3 btn btn-primary bg-beige-color w-100"
            style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Wachtwoord wijzigen</button>
        </div>
        <div class="col-1 text-center">
          <div class="d-flex">
            <div class="vertical-line" style="border-left: 3px solid #EFE3C4; height: 250px; margin: auto;"></div>
          </div>
        </div>
        <div class="col-8">
          <div id="accountCard" class="card bg-card-custom d-inline-block" style="position: relative; margin-top: 0px;">
            <div class="card-body overflow-auto">
              <div id="nameCard" class="card ms-4 mt-4 me-4"
                style="background-color: #EFE3C4; width: 120vh; height: 15vh;">
                <div class="text-center">
                  <div class="d-flex ms-3 mt-4">
                    <h1 style=" color: #2C231E;">Hallo
                      <? echo $user; ?>
                    </h1>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6 mt-5 text-center">
                  <p1 style=color:#EFE3C4>Persoonlijke gegevens</p1>
                </div>
                <div class="col-6 mt-5 text-center">
                  <p1 style=color:#EFE3C4>Cadeaubonnen</p1>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div id="nameCard" class="card ms-4 mt-3 me-4 w-90" style="background-color: #000; height: 25vh;">
                    <div class="text-center">
                      <div class="d-flex ms-3 mt-4">
                        </h1>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div id="nameCard" class="card ms-4 mt-3 me-4 w-90" style="background-color: #000; height: 25vh;">
                    <div class="text-center">
                      <div class="d-flex ms-3 mt-4">
                        </h1>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>