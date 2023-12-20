<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
    }

    .password-container {
        position: relative;

    }

    .line-hyper {
        content: "";
        display: block;
        width: calc(10 * 1.05 * 1em);
        max-width: 100%;
        border-bottom: 0.1em solid #EFE3C4;
        margin-left: 6.3rem;

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


<h1 style="color:#2C231E">Home</h1>
<p style="color:#2C231E">kiek</p>
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

<?foreach(\Lib\Enums\SortType::cases() as $sortType): ?>
        <label><?= $sortType->name ?>
    <input type="radio" name="SortType" value="<?= $sortType->name ?>">
        </label>
<? endforeach; ?>


<div class="container d-flex mb-5 mt-5 justify-content-center">
    <div class="card p-1 bg-card-custom w-75 d-inline-block">
        <div class="card-body">
            <form id="registerForm" method="POST" action="/Register" onsubmit="handleFormSubmission(event)">
                <div class="row">
                    <div class="col-auto mt-4 mb-3">
                        <h1 style="color:#EFE3C4">Registratie</h1>
                        <?= $spacer . $spacer ?>
                        <h3 style="color:#EFE3C4">Persoonlijke gegevens</h3>
                        <div class="spacer"></div>
                        <p style="color:#EFE3C4">Aanhef</p>
                        <?php foreach (['Mevrouw' => 'gender', 'De heer' => 'gender', 'Anders' => 'gender'] as $label => $name): ?>
                            <div class="col-auto form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="<?= $name ?>"
                                    value="<?php echo $label; ?>" required>
                                <label style="color:#EFE3C4" class="form-check-label" for="<?= $label ?>">
                                    <?= $label ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
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
                        // Increment the index
                        $index++;

                        // Check if it's the third field, and not the last field
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
                            <option value="1">Nederland</option>
                            <option value="2">België</option>
                            <option value="3">Luxemburg</option>
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
                            <button type="submit" id="saveButton" name="saveButton"
                                class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color"
                                style="background-color:#FCB716;border-color:#FCB716">Gegevens opslaan</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Success message div -->
            <div class="d-flex justify-content-center col-auto mt-5 ms-3 me-3">
                <div id="successMessageRegister" class="text-center text-start"
                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none; visibility: visible;color: green; z-index: 1000;">
                    <i class="bi bi-check-circle" style="font-size: 5em;color:#FCB716"></i>
                    <p class="mt-3" style="color:#EFE3C4">We hebben je een e-mail gestuurd met <br> daarin een
                        persoonlijke link.
                        <br> Via deze link kun je je registratie activeren.
                        <br> <br> Je ontvangt de mail binnen enkele minuten.<br> Of bekijk je spam inbox.
                    </p>
                    <a href="/Login" class="text-decoration-none" style="color:#EFE3C4">sluit deze pagina</a>
                    <div class="mb-5 line-hyper"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function togglePasswordVisibility(passwordName) {
        var passwordInput = document.getElementById(passwordName);


        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }


    function validatePasswords() {
        var password1 = document.getElementById('password').value;
        var password2 = document.getElementById('repeatPassword').value;

        if (password1 !== password2) {
            alert('Passwords do not match. Please try again.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }

    function handleFormSubmission(event) {
        event.preventDefault();  // Prevent the form from submitting and reloading the page
        
        // Validate passwords
        if (!validatePasswords()) {
            return false; // Prevent form submission
        }

        // Assuming this is where you want to display the success message
        var successMessage = document.getElementById('successMessageRegister');

        // Show the success message
        successMessage.style.display = 'block';
        successMessage.style.visibility = 'visible';

        // Hide the form
        var myForm = document.getElementById('registerForm');
        myForm.style.display = 'none';

        return false;  // Prevent the form from submitting and reloading the page
    }

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




</script>