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
    margin: 0;
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
    width: calc(10 * 0.92 * 1em);
    max-width: 100%;
    border-bottom: 0.1em solid #EFE3C4;


  }

  .password-container {
    position: relative;

  }

  .password-input {}

  .mt-Title-AccountCard {
    margin-top: 4.05rem;
    margin-left: 4rem;
  }

  .toggle-eye {
    position: absolute;
    top: 50%;
    left: 242px;
    transform: translateY(-50%);
    cursor: pointer;
  }

  .custom-icon-size {
    font-size: 8.2rem;
    /* Adjust the size as needed */
    color: #1C1713;
    top: -80px;
    left: 180px;

  }

  .custom-icon-InsideCard-size {
    font-size: 7rem;
    /* Adjust the size as needed */
    color: #EFE3C4;

  }

  .order-divider {
    position: relative;
    height: 0.2em;
    background-color: transparent;

    &::before,
    &::after {
      content: "";
      position: absolute;
      top: 0;
      width: 90%;
      height: 100%;
      background: linear-gradient(to right, transparent, #EFE3C4, transparent);
    }

    &::before {
      left: 0;
    }

    &::after {
      right: 0;
    }

    .order-border {
      content: "";
      display: block;
      width: calc(10 * 6.5 * 1em);
      max-width: 100%;
      border-bottom: 0.1em solid #EFE3C4;
    }


  }
  }
</style>

<?
$user = $firstname;

$fields = array(
  'Voornaam' => array('name' => 'firstname', 'placeholder' => $firstname),
  'Tussenvoegsel' => array('name' => 'middlename', 'placeholder' => $addition),
  'Achternaam' => array('name' => 'lastname', 'placeholder' => $lastname),
  'Postcode' => array('name' => 'zipcode', 'placeholder' => $zipcode),
  'Huisnummer' => array('name' => 'housenumber', 'placeholder' => $housenumber),
  'Toevoeging' => array('name' => 'addition', 'placeholder' => $housenumberextension),
  'Straat' => array('name' => 'street', 'placeholder' => $street),
  'Plaats' => array('name' => 'city', 'placeholder' => $city),
  'Telefoonnummer' => array('name' => 'phonenumber', 'placeholder' => 'Telefoonnummer'),
);
?>







<div id="accountPageContainer" class="container-fluid col-12 d-flex mb-5 mt-4 justify-content-center">
  <div id="accountBox">
    <div class="row">
      <div class="col-8 ms-5 mb-4 text-center">
        <h1 style=color:#EFE3C4>Mijn Account</h1>
      </div>
      <div class="row">
        <div class="col-2 ms-5">
          <div id="fixedButtonsContainer" class="fixed-buttons">
            <button type="button" id="logoutButton" class="btn btn-primary bg-beige-color w-100"
              style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Uitloggen</button>
            <button type="button" id="infoButton" class=" mt-3 btn btn-primary bg-beige-color w-100"
              style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Persoonlijke gegevens</button>
            <button type="button" id="orderHistoryButton" class="mt-3 btn btn-primary bg-beige-color w-100"
              style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Bestelgeschiedenis</button>
            <button type="button" id="changeInfoButton" class=" mt-3 btn btn-primary bg-beige-color w-100"
              style="background-color:#FCB716;border-color:#FCB716" name="logoutButton">Gegevens wijzigen</button>
          </div>
        </div>
        <div class="col-1 text-center">
          <div class="d-flex">
            <div id="line" class="vertical-line" style="border-left: 3px solid #EFE3C4; height: 800px; margin: auto;">
            </div>
          </div>
        </div>
        <div class="col-8 ">
          <div id="accountCard" class="card bg-card-custom d-inline-block"
            style="position: relative; margin-top: 0px;display: flex;">
            <div class="card-body">
              <div id="nameCard" class="card ms-4 mt-4 me-4"
                style="background-color: #EFE3C4; position: relative; width: 120vh; height: 25vh;">
                <div class="text-center">
                  <div class="d-flex mt-Title-AccountCard">
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
              <form id="InfoForm" style="display: <? echo !empty($updatedinfo) ? "none" : "block" ?>;">
                <div class="row">
                  <div class="col-6 mt-5 ms-5">
                    <h5 style=color:#EFE3C4>Persoonlijke gegevens</h5>
                  </div>
                  <div class="col-4 mt-5 ms-1">
                    <h5 style=color:#EFE3C4>Laatste bestelling</h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <div id="infoCard" class="card ms-4 mt-3 me-4 w-90" style="background-color: #000; height: 33vh;">
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
                            <? echo (isset($street) ? $street : "") . " " . (isset($housenumber) ? $housenumber : "") . (isset($housenumberextension) ? $housenumberextension : "") ?>
                          </p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col ms-3">
                          <p style=color:#FFFFFF class="mb-4">
                            <? echo (isset($zipcode) ? $zipcode : "") . " " . (isset($city) ? $city : "") ?>
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
                      <div id="specialIconContainerInfo" style="position: absolute; top: -5%; left: 65%;">
                        <i class="bi bi-person-fill custom-icon-InsideCard-size"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div id="giftCard" class="card ms-4 mt-3 me-4 w-90" style="background-color: #000; height: 33vh;">
                    </div>
                  </div>
                </div>
              </form>
              <!-- start order history tab -->
              <form id="orderHistory" style="display: none;">
                <div class="row text-center mt-5">
                  <h4 style=color:#EFE3C4>Bestelgeschiedenis</h4>
                </div>
                <div class="row justify-content-center mt-5">
                </div>
                <div class="row mt-2">
                  <div id="orderHistoryContainer"></div>
                </div>
              </form>
              <!-- start change info tab -->
              <form id="ChangePersonalInfo" style="display: <? echo !empty($updatedinfo) ? "block" : "none" ?>;">
                <div class="row text-center mt-5">
                  <h4 style=color:#EFE3C4>Wijzigen persoonlijke gegevens</h4>
                  <i>
                    <p style=color:#EFE3C4>Vul in wat u wenst te wijzigen, overige gegevens mag u leeg laten.</p>
                  </i>
                  <b>
                    <p id="InfoUpdatedText"
                      style="color:#FCB716;display: <? echo !empty($updatedinfo) ? "block" : "none" ?>" ;>Gegevens
                      gewijzigd!</p>
                  </b>
                </div>
                <div class="row ms-3 me-3 mt-3 mb-4 justify-content-center">
                  <?php $index = 0;
                  foreach ($fields as $label => $field): ?>
                    <div class="col-4">
                      <input type="text" class="form-control bg-beige-color" id="<?= $field['name'] ?>"
                        name="<?= $field['name'] ?>"
                        placeholder="<?php echo !empty($field['placeholder']) ? $field['placeholder'] : $label; ?>">
                    </div>

                    <?php
                    $index++;
                    if ($index % 3 === 0 && $index < count($fields)) {
                      echo '</div><div class="row ms-3 me-3 mb-4 justify-content-center">';
                    }
                    ?>
                  <?php endforeach; ?>
                </div>
                <div class="row ms-3 me-3 mt-4 mb-4 justify-content-center">
                  <div class="col-4">
                    <select class="form-select bg-beige-color" id="country" name="country">
                      <?php foreach (\Lib\Enums\Country::cases() as $countryOption): ?>
                        <option value="<?= $countryOption->toString() ?>" <?= ($country == $countryOption->value) ? 'selected' : '' ?>>
                          <?= $countryOption->toStringTranslate() ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-4">
                    <input type="date" class="form-control bg-beige-color" id="birthdate" name="birthdate"
                      value="<? echo $birthdate; ?>" min="1900-01-01" max="2050-12-31">
                  </div>
                  <div class="col-4">
                    <select class="form-select bg-beige-color" id="gender" name="gender">
                      <?php foreach (\Lib\Enums\Gender::cases() as $GenderOption): ?>
                        <option value="<?= $GenderOption->toString() ?>" <?= ($gender == $GenderOption->value) ? 'selected' : '' ?>>
                          <?= $GenderOption->toStringTranslate() ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="row ms-3 me-3 mt-5 justify-content-center text-center">
                  <div class="col-4 text-center">
                    <button type="button" id="saveChangeInfoButton" name="saveChangeInfoButton"
                      class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color"
                      style="width: 100%;background-color:#FCB716;border-color:#FCB716">Gegevens wijzigen</button>
                  </div>
                </div>
              </form>
              <form id="ChangeEmailAndPassword" style="display: <? echo !empty($updatedinfo) ? "block" : "none" ?>;">
                <div class="row ms-3 me-3 mt-5 justify-content-center text-center">
                  <h4 style=color:#EFE3C4>Wachtwoord en/of e-mail wijzigen</h4>
                </div>
                <div class="row mt-4 ms-3 me-3 mb-5 text-center">
                  <i>
                    <p style=color:#EFE3C4>Als u uitsluitend uw wachtwoord wilt wijzigen, hoeft u het e-mailadres
                      niet opnieuw in te voeren. Indien u echter besluit het e-mailadres te wijzigen, dient u uw
                      account opnieuw te activeren. Na het aanpassen van het e-mailadres en/of uw wachtwoord,
                      wordt u automatisch uitgelogd en dient u opnieuw in te loggen.</p>
                  </i>
                </div>
                <div class="row mt-4 ms-3 me-3 mb-1 justify-content-center">
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
                  <div class="col-3 mb-1 text-center">
                    <button type="button" id="saveChangePasswordButton" name="saveChangePasswordButton"
                      class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color"
                      style="background-color:#FCB716;border-color:#FCB716">Wachtwoord wijzigen</button>
                  </div>
                </div>
                <div class="row mt-2 ms-3 me-3 mb-1 justify-content-center">
                  <div class="col-4">
                    <input type="email" class="form-control bg-beige-color" id="email" name="email"
                      placeholder="<? echo $email ?>">
                  </div>
                  <div class="col-4">
                    <input type="email" class="form-control bg-beige-color" id="repeatEmail" name="repeatEmail"
                      placeholder="<? echo $email ?>">
                  </div>
                  <div class="col-3 mb-3 text-center">
                    <button type="button" id="saveChangeEmailButton" name="saveChangeEmailButton"
                      class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color"
                      style="background-color:#FCB716;border-color:#FCB716">E-mailadres wijzigen</button>
                  </div>
                </div>
                <div class="row text-center justify-content-center mt-5">
                  <i><a data-bs-toggle="modal" href="#myModal" class="text-decoration-none"
                      style="color:#EFE3C4">Account
                      verwijderen</a></i>
                  <div class="line-hyper"></div>
                </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content" style="background-color: #2C231E;">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: #1C1713;border-color: #1C1713;">
        <h4 class="modal-title" style=color:#EFE3C4>Account verwijderen</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p1 style=color:#EFE3C4>Weet u zeker dat u uw account wilt verwijderen?</p1>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="border-color: #2C231E;">
        <button type="button" style="background-color:#FCB716;border-color:#FCB716"
          class="btn btn-primary rounded-pill bg-beige-color" href="/" id="deleteAccountBtn"
          data-bs-dismiss="modal">Ja</button>
        <button type="button" style="background-color:#FCB716;border-color:#FCB716"
          class="btn btn-primary rounded-pill bg-beige-color" data-bs-dismiss="modal">Nee</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {

    function toggleFormsAndChangeIcon(showInfoForm, showChangePersonalInfo, showOrderHistory) {
      const accountCard = document.getElementById("accountCard");
      const infoForm = accountCard.querySelector("#InfoForm");
      const changePersonalInfoForm = accountCard.querySelector("#ChangePersonalInfo");
      const ChangeEmailAndPasswordForm = accountCard.querySelector('#ChangeEmailAndPassword');
      const orderHistory = accountCard.querySelector("#orderHistory");
      const accountIcon = document.getElementById("accountIcon");
      const changeText = accountCard.querySelector('#InfoUpdatedText');


      infoForm.style.display = showInfoForm ? "block" : "none";
      changePersonalInfoForm.style.display = showChangePersonalInfo ? "block" : "none";
      ChangeEmailAndPasswordForm.style.display = showChangePersonalInfo ? "block" : "none";
      orderHistory.style.display = showOrderHistory ? "block" : "none";
      changeText.style.display = "none";

      if (showInfoForm) {
        accountIcon.className = "bi bi-person-vcard-fill custom-icon-size";
      } else if (showChangePersonalInfo) {
        accountIcon.className = "bi bi-person-fill-gear custom-icon-size";
      } else if (showOrderHistory) {
        accountIcon.className = "bi bi-collection-fill custom-icon-size";
      }
    }

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

  //--------------Getting orderhistory from database----------------------------------------
  $(document).ready(function () {
    $("#orderHistoryButton").on("click", function () {
      event.preventDefault();
      $.ajax({
        url: "/RetrievingOrderHistory",
        type: "POST",
        dataType: "json",
        success: function (response) {

          console.log(response);
          updateOrderHistoryForm(response)
        },
        error: function (xhr, status, error) {

          console.error(xhr);
          console.error(status);
        }
      });
    });
  });

  function updateOrderHistoryForm(orderHistoryData) {
    const orderHistoryContainer = document.getElementById('orderHistoryContainer');
    orderHistoryContainer.innerHTML = '';

    orderHistoryData.forEach(function (order) {
      const orderDate = new Date(order.createdOn.date);
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      const formattedDate = orderDate.toLocaleDateString('nl-NL', options);
      const orderTotal = order.orderTotal
      const taxTotal = order.orderTax / 100
      const finalTotal = orderTotal * (1 + taxTotal)

      const orderElement = document.createElement('div');
      orderElement.innerHTML = `<h6 style=color:#EFE3C4>Bestelnummer: ${order.id} | ${formattedDate}</h6> <br> <p6 style=color:#EFE3C4>Totaal bedrag: €${finalTotal}</p6><div class="row justify-content-center mt-5 mb-4"><div class="order-divider"></div></div>`;
      orderHistoryContainer.appendChild(orderElement);
    });
  }
  //--------------Logging out---------------------------------------------------------------
  $(document).ready(function () {
    $("#logoutButton").on("click", function () {
      $.ajax({
        url: "/logout",
        type: "POST",
        success: function (response) {

          window.location.href = "/Login";

        },
        error: function (xhr, status, error) {

          console.error(xhr);
          console.error(status);
        }
      });
    });
  });

  //---------------saving regular info changed----------------------------------------------

  $(document).ready(function () {
    $("#saveChangeInfoButton").on("click", function () {
      event.preventDefault();

      var additionalData = {
        key: 'infoUpdated'
      };

      var serializedData = $("#ChangePersonalInfo").serialize();
      var combinedData = serializedData + '&' + $.param(additionalData);

      $.ajax({
        url: "/UpdateInfo",
        type: "POST",
        data: combinedData,
        success: function (response) {
          console.log(response);
          window.location.href = "/Account";

        },
        error: function (xhr, status, error) {
          console.error(xhr);
          console.error(status);
        }
      });
    });
  });

  //-----------------save changed passwords--------------------------------------------------

  function validatePasswords() {
    var password1 = document.getElementById('changePassword').value;
    var password2 = document.getElementById('repeatChangePassword').value;

    if (password1 !== password2) {
      alert('Wachtwoorden zijn niet hetzelfde, probeer het .');
      return false;
    }

    return true;
  }

  $(document).ready(function () {

    $("#saveChangePasswordButton").on("click", function () {
      event.preventDefault();

      if (!validatePasswords()) {
        return;
      }

      $.ajax({
        url: "/UpdateUserPassword",
        type: "POST",
        data: $("#ChangeEmailAndPassword").serialize(),
        success: function (response) {
          $.ajax({
            url: "/logout",
            type: "POST",
            success: function (response) {
              window.location.href = "/Login";
            },
            error: function (xhr, status, error) {
              console.error(xhr);
              console.error(status);
            }
          });
        },
        error: function (xhr, status, error) {
          console.error(xhr);
          console.error(status);
        }
      });
    });
  });

  //-------------Update email script-----------------------------------------------------------


  // making sure the entered email is a valid type of email
  function isValidEmail(email) {

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  // making sure the emails are the same.
  function validateEmails() {
    var email1 = document.getElementById('email').value;
    var email2 = document.getElementById('repeatEmail').value;

    if (email1 !== email2) {
      alert('E-mailadressen zijn niet hetzelfde, probeer het opnieuw.');
      return false;
    }

    return true;
  }

  //----------------------save email change-----------------------------------------------------
  $(document).ready(function () {
    $("#saveChangeEmailButton").on("click", function () {
      event.preventDefault();

      if (!validateEmails()) {
        return;
      }

      const emailAddress = document.getElementById('email').value;
      if (isValidEmail(emailAddress)) {
        return true;
      } else {
        alert('Het ingevoerde emailadres is niet geldig.');
        return false;
      }

      $.ajax({
        url: "/UpdateEmail",
        type: "POST",
        data: $("#ChangeEmailAndPassword").serialize(),
        success: function (response) {
          console.log(response);
          $.ajax({
            url: "/logout",
            type: "POST",
            success: function (response) {
              window.location.href = "/Login";
            },
            error: function (xhr, status, error) {
              console.error(xhr);
              console.error(status);
            }
          });
        },
        error: function (xhr, status, error) {
          console.error(xhr);
          console.error(status);
        }
      });
    });

  });


  //----------------Account deletion--------------------------------------------------------

  $(document).ready(function () {

    $("#deleteAccountBtn").on("click", function (event) {
      event.preventDefault();

      $.ajax({
        type: "POST",
        url: "/deleteAccount",
        success: function (response) {
          window.location.href = "/AccountDeleted";
        },
        error: function (xhr, status, error) {
          console.error("Error deleting account:", status, error);
        }
      });
    });
  });

</script>