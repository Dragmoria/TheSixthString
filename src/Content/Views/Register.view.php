<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<script>


    function togglePasswordVisibility(passwordName) {
        console.log("jQuery is defined:", typeof jQuery !== 'undefined');
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


    input[type="radio"]:checked {
        background-color: #FCB716;
        border-color: #FCB716;
        box-shadow: 0 0 0 0rem #FCB716
    }

    input[type="radio"]:focus {
        border-color: #FCB716;
        box-shadow: 0 0 0 0rem #FCB716
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
        width: 60%;
    }

    .bg-card-succes {
        background-color: #1C1713;
        width: 90vh;
        height: 70vh;
    }

    .password-container {
        position: relative;

    }

    .line-hyper {
        content: "";
        display: block;
        width: calc(10 * 0.80 * 1em);
        max-width: 100%;
        border-bottom: 0.1em solid #EFE3C4;
        margin-left: 5.7rem;

    }

    .password-input {}

    .toggle-eye {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>


<? $date = date("Y-m-d");
$spacer = '<div class="spacer"></div>';
$fields = array(
    'Voornaam *' => array('name' => 'firstname', 'importance' => 'required'),
    'Tussenvoegsel' => array('name' => 'middlename', 'importance' => 'notrequired'),
    'Achternaam *' => array('name' => 'lastname', 'importance' => 'required'),
    'Postcode *' => array('name' => 'zipcode', 'importance' => 'required'),
    'Huisnummer *' => array('name' => 'housenumber', 'importance' => 'required'),
    'Toevoeging' => array('name' => 'addition', 'importance' => 'notrequired'),
    'Straat *' => array('name' => 'street', 'importance' => 'required'),
    'Plaats *' => array('name' => 'city', 'importance' => 'required'),
    'Telefoonnummer' => array('name' => 'phonenumber', 'importance' => 'notrequired')
);
?>




<div id="RegisterPageContainer" class="container-fluid d-flex mb-5 justify-content-center">
    <div id="registrationCard" class="card bg-card-custom d-inline-block" style="position: relative; margin-top: 0px;">
        <div class="card-body">
            <form id="registerForm" method="POST" action="/Register" onsubmit="handleFormSubmission(event)">
                <div class="row">
                    <div class="col-auto mt-4 mb-3">
                        <h1 style="color:#EFE3C4">Registratie</h1>
                        <?= $spacer . $spacer ?>
                        <h3 style="color:#EFE3C4">Persoonlijke gegevens</h3>
                        <div class="spacer"></div>
                        <p style="color:#EFE3C4">Aanhef</p>
                        <?php foreach (\Lib\Enums\Gender::cases() as $gender): ?>
                            <div class="col-auto form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="<?= $gender->toString() ?>"
                                    value="<?php echo $gender->toString(); ?>" required>
                                <label style="color:#EFE3C4" class="form-check-label" for="<?= $gender->toString() ?>">
                                    <?= $gender->toStringTranslate() ?>
                                </label>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
                <div class="row">
                    <?php $index = 0;
                    foreach ($fields as $label => $field): ?>
                        <div class="col-lg-4 col-xl-4 col-sm-12 mb-3 col-md-8">
                            <input type="text" class="form-control bg-beige-color" id="<?= $field['name'] ?>"
                                name="<?= $field['name'] ?>" placeholder="<?php echo $label; ?>" <?php echo ($field['importance'] === 'required') ? 'required' : ''; ?>>
                        </div>

                        <?php
                        $index++;
                        if ($index % 3 === 0 && $index < count($fields)) {
                            echo '</div><div class="row">';
                        }
                        ?>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xl-4 col-sm-12 mb-3 col-md-8">
                        <select class="form-select bg-beige-color" id="country" name="country" required>
                            <option value="" disabled selected>Selecteer land</option>
                            <? foreach (\Lib\Enums\Country::cases() as $country): ?>
                                <option value="<?= $country->toString() ?>">
                                    <?= $country->toStringTranslate() ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-4 col-xl-4 col-sm-12 mb-3 col-md-8">
                        <input type="date" class="form-control bg-beige-color" id="birthdate" name="birthdate"
                            min="1900-01-01" max="2050-12-31" / required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto ms-sm-1 ms-lg-4 ms-xl-4 mb-3 col-md-8">
                        <i>
                            <p style="color:#EFE3C4">* is verplicht</p>
                        </i>
                    </div>
                    <div class="spacer"></div>
                    <div class="col-auto mb-3">
                        <h2 style="color:#EFE3C4">Inloggegevens</h2>
                    </div>
                    <div class="spacer"></div>
                </div>
                <div class="row">
                    <?php foreach (['E-mailadres' => 'email', 'Wachtwoord' => 'password', 'Herhalen wachtwoord' => 'repeatPassword'] as $label => $name): ?>
                        <div class="col-lg-4 col-xl-4 col-sm-12 mb-3 col-md-8">
                            <?php if ($name === 'password' || $name === 'repeatPassword'): ?>
                                <div class="password-container">
                                    <input type="<?= $label === 'email' ? 'text' : 'password' ?>"
                                        class="form-control bg-beige-color password-input" id="<?= $name ?>" name="<?= $name ?>"
                                        placeholder="<?= $label ?>" required>
                                    <i class="bs bi-eye-slash-fill toggle-eye"
                                        onclick="togglePasswordVisibility('<?= $name ?>')"></i>
                                </div>
                            <?php else: ?>
                                <input type="text" class="form-control form-check-inline bg-beige-color" id="<?= $name ?>"
                                    name="<?= $name ?>" placeholder="<?= $label ?>" required>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <div class="spacer"></div>
                    <div class="row">
                        <div class="col-lg-12 col-xl-12 col-sm-12 mb-3 mb-2 ms-1 text-center ">
                            <button type="button" id="saveButton" name="saveButton"
                                class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color"
                                style="background-color:#FCB716;border-color:#FCB716">Gegevens opslaan</button>
                        </div>
                    </div>
                </div>
            </form>



            <!-- Success message  -->
            <div class="d-flex justify-content-center col-auto mt-5">
                <div id="successMessageRegister" class="text-center text-start"
                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none; visibility: visible;color: green; z-index: 1000;">
                    <i class="bi bi-check-circle" style="font-size: 5em;color:#FCB716"></i>
                    <p class="mt-3" style="color:#EFE3C4">We hebben je een e-mail gestuurd met <br> daarin een
                        persoonlijke link.
                        <br> Via deze link kun je je registratie activeren.
                        <br> <br> Je ontvangt de mail binnen enkele minuten.<br> Of bekijk je spam inbox.
                    </p>
                    <a href="/Login" class="text-decoration-none" style="color:#EFE3C4">sluit deze pagina</a>
                    <div class="line-hyper"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    function validatePasswords() {
        var password1 = document.getElementById('password').value;
        var password2 = document.getElementById('repeatPassword').value;

        if (password1 !== password2) {
            alert('Passwords do not match. Please try again.');
            return false;
        }

        return true;
    }

    $(document).ready(function () {
        $("#saveButton").on("click", function () {

            if (!validatePasswords()) {
                return;
            }


            if ($("#registerForm")[0].checkValidity()) {

                $.ajax({
                    url: "/RegisterValidate",
                    type: "POST",
                    data: $("#registerForm").serialize(),
                    success: function (response) {
                        if (response === "UserExists") {
                            alert("Het ingevoerde e-mailadres is al in gebruik");
                        }
                        else {
                        var myForm = $("#registerForm");
                        myForm.hide();

                        var successMessage = $("#successMessageRegister");
                        successMessage.show();

                        var MyCard = $("#registrationCard")
                            var MyContainer = $("#RegisterPageContainer")

                            MyCard.removeClass("bg-card-custom").addClass("bg-card-succes");
                    }
                },
                    error: function (xhr, status, error) {
                        alert("An error occurred: " + error);
                        console.error(xhr);
                        console.error(status);
                    }
                });
    } else {

        $("#registerForm")[0].reportValidity();
    }
        });
    });
</script>