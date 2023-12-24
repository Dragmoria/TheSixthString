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

  .mt-Title-AccountCard {
    margin-top: 4rem;
  }

  .toggle-eye {
    position: absolute;
    top: 50%;
    left: 192px;
    transform: translateY(-50%);
    cursor: pointer;
  }

  .custom-icon-size {
    font-size: 8.2rem;
    /* Adjust the size as needed */
    color: #1C1713;
    top: -82px;
    left: 175px;

  }
</style>

<?
$user = $_SESSION["user"]["firstname"];
?>







<div id="accountPageContainer" class="container-fluid col-12 d-flex mb-5 mt-4 justify-content-center">
  <form id="accountForm" method="POST" action="/Account">
    <div class="row">
      <div class="col-8 ms-5 mb-4 text-center">
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
            style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Gegevens wijzigen</button>
        </div>
        <div class="col-1 text-center">
          <div class="d-flex">
            <div class="vertical-line" style="border-left: 3px solid #EFE3C4; height: 720px; margin: auto;"></div>
          </div>
        </div>
        <div class="col-8 ">
          <div id="accountCard" class="card bg-card-custom d-inline-block" style="position: relative; margin-top: 0px;">
            <div class="card-body">
              <div id="nameCard" class="card ms-4 mt-4 me-4"
                style="background-color: #EFE3C4; position: relative; width: 120vh; height: 25vh;">
                <div class="text-center">
                  <div class="d-flex ms-4 mt-Title-AccountCard">
                    <h1 style=" color: #2C231E;">Hallo
                      <? echo $user; ?>
                    </h1>
                    <div class="col">
                      <i class="bi bi-person-lines-fill custom-icon-size" style=" position: relative;"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- start personal info tab -->
              <div id="InfoForm" style="display: block;">
                <div class="row">
                  <div class="col-6 mt-5 ms-5">
                    <h5 style=color:#EFE3C4>Persoonlijke gegevens</h5>
                  </div>
                  <div class="col-4 mt-5 ms-1">
                    <h5 style=color:#EFE3C4>Cadeaubonnen</h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <div id="nameCard" class="card ms-4 mt-3 me-4 w-90" style="background-color: #000; height: 33vh;">
                      <div class="row">
                        <div class="col ms-3 mt-2">
                          <h5 style=color:#FFFFFF class="mt-3">Dit ben jij</h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col ms-3 mt-1">
                          <p style=color:#FFFFFF class="mb-0">
                            <?php echo $firstname . (isset($addition) ? " " . $addition . " " : " ") . $lastname; ?>
                          </p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col ms-3">
                          <p style=color:#FFFFFF class="mb-0">
                            <? echo $street . " " . $housenumber . (isset($housenumberextension) ? $housenumberextension : "") ?>
                          </p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col ms-3">
                          <p style=color:#FFFFFF class="mb-4">
                            <? echo $zipcode . " " . $city ?>
                          </p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col ms-3">
                          <p style=color:#FFFFFF class="mb-0 mt-2">
                            Klantnummer:
                            <? echo $klantnummer ?>
                          </p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col ms-3">
                          <p style=color:#FFFFFF>
                            <? echo $email ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div id="nameCard" class="card ms-4 mt-3 me-4 w-90" style="background-color: #000; height: 33vh;">
                      <div class="text-center">
                        <div class="d-flex ms-3 mt-4">
                          </h1>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6 mt-5 ms-5">
                      <h5 style=color:#EFE3C4>Laatste bestelling</h5>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div id="nameCard" class="card ms-4 mt-3 me-4 w-90" style="background-color: #000; height: 33vh;">
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
              <!-- end personal info tab -->
              <div id="ChangePersonalInfo" style="display: none;">


              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>