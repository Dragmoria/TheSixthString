<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

<script>


  function togglePasswordVisibility(passwordName) {
    var passwordInput = document.getElementById(passwordName);


    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
    } else {
      passwordInput.type = 'password';
    }
  }
  document.addEventListener('DOMContentLoaded', function () {

    var passwordInputs = document.querySelectorAll('.password-input');


    passwordInputs.forEach(function (passwordInput) {

      var eyeIcon = passwordInput.parentElement.querySelector('.toggle-eye');
      eyeIcon.style.display = 'none';


      passwordInput.addEventListener('input', function () {

        eyeIcon.style.display = passwordInput.value.trim() !== '' ? 'block' : 'none';
      });


      eyeIcon.addEventListener('mousedown', function () {
        togglePasswordVisibility(passwordInput.id);
      });
    });
  });
</script>

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
    left: 250px;
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

  .custom-icon-InsideCard-size {
    font-size: 7rem;
    /* Adjust the size as needed */
    color: #EFE3C4;

  }
</style>

<?
$user = $_SESSION["user"]["firstname"];

$fields = array(
  'Postcode' => array('name' => 'zipcode', 'type' => 'text'),
  'Huisnummer' => array('name' => 'housenumber', 'type' => 'text'),
  'Toevoeging' => array('name' => 'addition', 'type' => 'text'),
  'Straat' => array('name' => 'street', 'type' => 'text'),
  'Plaats' => array('name' => 'city', 'type' => 'text'),
  'Telefoonnummer' => array('name' => 'phonenumber', 'type' => 'text'),
);
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
          <button type="button" id="infoButton" class=" mt-3 btn btn-primary bg-beige-color w-100"
            style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Persoonlijke gegevens</button>
          <button type="button" id="orderHistoryButton" class="mt-3 btn btn-primary bg-beige-color w-100"
            style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Bestelgeschiedenis</button>
          <button type="button" id="changeInfoButton" class=" mt-3 btn btn-primary bg-beige-color w-100"
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
                    <h1 id="titleText" style=" color: #2C231E;">Hallo
                      <? echo $user; ?>
                    </h1>
                    <div class="col">
                      <i id="accountIcon" class="bi bi-person-vcard-fill custom-icon-size custom-icon-size"
                        style=" position: relative;"></i>
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
                      <div id="specialIconContainer" style="position: absolute; top: -5%; left: 65%;">
                        <i class="bi bi-person-fill custom-icon-InsideCard-size"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div id="nameCard" class="card ms-4 mt-3 me-4 w-90" style="background-color: #000; height: 33vh;">
                      <div class="text-center">
                        <div class="d-flex ms-3 mt-4">
                          <div class="container mt-5">

                          </div>
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
              <!-- start order history tab -->
              <div id="orderHistory" style="display: none;">
                <div class="row text-center mt-5">
                  <h4 style=color:#EFE3C4>Bestelgeschiedenis</h4>
                </div>
              </div>
              <!-- start change info tab -->
              <div id="ChangePersonalInfo" style="display: none;">
                <div class="row text-center mt-5">
                  <h4 style=color:#EFE3C4>Wijzigen persoonlijke gegevens</h4>
                  <i>
                    <p style=color:#EFE3C4>Vul in wat u wenst te wijzigen, overige gegevens mag u leeg laten.</p>
                  </i>
                </div>
                <div class="row mt-4 mb-4 justify-content-center">
                  <?php $index = 0;
                  foreach ($fields as $label => $field): ?>
                    <div class="col-4">
                      <input type="<? echo $field['type']; ?>" class="form-control bg-beige-color"
                        id="<?= $field['name'] ?>" name="<?= $field['name'] ?>" placeholder="<?php echo $label; ?>">
                    </div>

                    <?php
                    $index++;
                    if ($index % 2 === 0 && $index < count($fields)) {
                      echo '</div><div class="row mb-4 justify-content-center">';
                    }
                    ?>
                  <?php endforeach; ?>
                </div>
                <div class="row mt-4 justify-content-center text-center">
                  <div class="col-lg-12 col-xl-12 col-sm-12 mb-3 mb-2 ms-1 text-center ">
                    <button type="button" id="saveChangeInfoButton" name="saveChangeInfoButton"
                      class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color"
                      style="background-color:#FCB716;border-color:#FCB716">Gegevens wijzigen</button>
                  </div>
                </div>
                <div class="row mt-5 justify-content-center text-center">
                  <h4 style=color:#EFE3C4>Wachtwoord wijzigen</h4>
                </div>
                <div class="row mt-4 justify-content-center">
                  <div class="col-4">
                    <div class="password-container">
                      <input type="password" class="form-control bg-beige-color password-input" id="changePassword"
                        name="changePassword" placeholder="Wachtwoord">
                      <i class="bs bi-eye-slash-fill toggle-eye"
                        onclick="togglePasswordVisibility('changePassword')"></i>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="password-container">
                      <input type="password" class="form-control bg-beige-color password-input"
                        id="repeatChangePassword" name="repeatChangePassword" placeholder="Wachtwoord herhalen">
                      <i class="bs bi-eye-slash-fill toggle-eye"
                        onclick="togglePasswordVisibility('repeatChangePassword')"></i>
                    </div>
                  </div>
                </div>
                <div class="row mt-4 justify-content-center text-center">
                  <div class="col-lg-12 col-xl-12 col-sm-12 mb-3 mb-2 ms-1 text-center ">
                    <button type="button" id="saveChangePasswordButton" name="saveChangePasswordButton"
                      class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color"
                      style="background-color:#FCB716;border-color:#FCB716">Wachtwoord wijzigen</button>
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


<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Function to toggle visibility of forms and change icon
    function toggleFormsAndChangeIcon(showInfoForm, showChangePersonalInfo, showOrderHistory) {
      const infoForm = document.getElementById("InfoForm");
      const changePersonalInfoForm = document.getElementById("ChangePersonalInfo");
      const orderHistory = document.getElementById("orderHistory");
      const accountIcon = document.getElementById("accountIcon");

      infoForm.style.display = showInfoForm ? "block" : "none";
      changePersonalInfoForm.style.display = showChangePersonalInfo ? "block" : "none";
      orderHistory.style.display = showOrderHistory ? "block" : "none";

      // Change icon class based on the form being displayed
      if (showInfoForm) {
        accountIcon.className = "bi bi-person-vcard-fill custom-icon-size";
      } else if (showChangePersonalInfo) {
        accountIcon.className = "bi bi-person-fill-gear custom-icon-size";
      } else if (showOrderHistory) {
        accountIcon.className = "bi bi-collection-fill custom-icon-size";
      }
      // Add more conditions for other forms and icons
    }

    // Add click event listeners to the buttons
    const infoButton = document.getElementById("infoButton");
    const changeInfoButton = document.getElementById("changeInfoButton");
    const orderHistoryButton = document.getElementById("orderHistoryButton");

    infoButton.addEventListener("click", function () {
      toggleFormsAndChangeIcon(true, false, false);
    });

    changeInfoButton.addEventListener("click", function () {
      toggleFormsAndChangeIcon(false, true, false);
    });

    orderHistoryButton.addEventListener("click", function () {
      toggleFormsAndChangeIcon(false, false, true);
    });
  });
</script>


<!--bi bi-gift-fill - persoonlijke gegevens =>bi bi-person-fill -->