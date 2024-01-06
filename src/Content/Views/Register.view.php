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




<div id="RegisterPageContainer" class="mt-5 container-fluid d-flex mb-3 justify-content-center vh-100">
    <div id="registrationCard" class="card bg-card-custom d-inline-block" style="position: relative; margin-top: 0px;">
        <div class="card-body">
            <form id="registerForm" method="POST" action="/Register" onsubmit="handleFormSubmission(event)">
                <div class="row">
                    <div class="col-auto mt-4 mb-3">
                        <h1 style="color:#EFE3C4">Registratie</h1>
                        <?= $spacer . $spacer ?>
                        <h3 class="mb-3" style="color:#EFE3C4">Persoonlijke gegevens</h3>
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
                            min="1900-01-01" max="2050-12-31" required>
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
                    <?php foreach (['E-mailadres' => 'email', 'Herhalen e-mailadres' => 'repeatEmail'] as $label => $name): ?>
                        <div class="me-3 col-lg-5 col-xl-5 col-sm-12 mb-3 col-md-8">
                            <input type="text" class="form-control form-check-inline bg-beige-color" id="<?= $name ?>"
                                name="<?= $name ?>" placeholder="<?= $label ?>" required>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <?php foreach (['Wachtwoord *' => 'password', 'Herhalen wachtwoord *' => 'repeatPassword'] as $label => $name): ?>
                        <div class="me-3 col-lg-5 col-xl-5 col-sm-12 mb-3 col-md-8">
                            <div class="password-container">
                                <input type="password" class="form-control bg-beige-color password-input" id="<?= $name ?>"
                                    name="<?= $name ?>" placeholder="<?= $label ?>" required>
                                <i class="bs bi-eye-slash-fill toggle-eye"
                                    onclick="togglePasswordVisibility('<?= $name ?>')"></i>
                            </div>
                        </div>
                    <? endforeach; ?>
                    <div class="row">
                        <i>
                            <p style="color:#EFE3C4">* Wachtwoorden moeten ten minste 6 tekens bevatten, inclusief ten
                                minste 1 hoofdletter, 1 kleine letter en 1 cijfer.</p>
                        </i>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-xl-12 col-sm-12 ms-1 mt-4 text-center ">
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
                        <br> <br> Je ontvangt de mail binnen enkele minuten.<br> Of bekijk je spam inbox. <br><br> <b>
                            Let
                            op, pas na activatie kunt u inloggen!</b>
                    </p>
                    <a href="/Login" class="text-decoration-none" style="color:#EFE3C4">sluit deze pagina</a>
                    <div class="line-hyper"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/Js/ShowHidePassword.js"></script>
<script src="/Js/RegisterUser.js"></script>
