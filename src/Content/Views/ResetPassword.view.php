<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

<?
if (isset($succes)) {
    $user = $succes;
}
$displayForm1 = empty($error);
?>

<script>
    $("#succesForm").hide();

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
        left: 245px;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>




<div id="ResetPasswordContainer" class="container-fluid col-12 d-flex mb-5 mt-4 justify-content-center">
    <form style="display: <?php echo $displayForm1 ? 'block' : 'none'; ?>" id="ResetPasswordForm" method="POST"
        action="/Login" onsubmit="handleFormSubmission(event)">
        <div id="accountCard" class="card bg-card-custom d-inline-block" style="position: relative; margin-top: 0px;">
            <div class="card-body text-center">
                <h1 style=color:#EFE3C4>Welkom <? echo $user ?></h1>
                <div class="mt-3 row justify-content-center">
                    <p style=color:#EFE3C4>Wachtwoord wijzigen</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-8 mt-2">
                        <?php foreach (['Niew wachtwoord' => 'password', 'Herhalen wachtwoord' => 'repeatPassword'] as $label => $name): ?>
                            <div class="password-container">
                                <input type="password" class="mt-3 form-control bg-beige-color password-input"
                                    id="<?= $name ?>" name="<?= $name ?>" placeholder="<?= $label ?>" required>
                                <i class="bs bi-eye-slash-fill toggle-eye"
                                    onclick="togglePasswordVisibility('<?= $name ?>')"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row  text-center">
                        <div class="mt-5">
                            <button type="button" id="updateButton" name="updateButton"
                                class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color"
                                style="background-color:#FCB716;border-color:#FCB716">wachtwoord wijzigen</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="LinkExpiredForm" style="display: <?php echo $displayForm1 ? 'none' : 'block'; ?>">
        <div id="accountCard" class="card bg-card-custom d-inline-block" style="position: relative; margin-top: 0px;">
            <div class="row text-center">
                <h1 style=color:#EFE3C4>Welkom</h1>
                <div class="col-12">
                    <p1 style=color:#EFE3C4>De link is verlopen, vraag </p1><u><a href="/ForgotPassword"
                            class="text-decoration-none"
                            style="color:#EFE3C4; text-decoration: underline !important;">hier</a></u>
                    <p1 style=color:#EFE3C4> een nieuwe link aan.</p1>
                    <div class="card-body text-center">
                    </div>
                </div>
            </div>
        </div>
    </form>


    <form id="SuccesForm" style="display: none">
        <div id="accountCard" class="card bg-card-custom d-inline-block" style="position: relative; margin-top: 0px;">
            <div class="row text-center">
                <h1 style=color:#EFE3C4>Gelukt!</h1>
                <div class="col-12">
                    <p1 style=color:#EFE3C4>Uw wachtwoord is gewijzigd, ga </p1><u><a href="/Login"
                            class="text-decoration-none"
                            style="color:#EFE3C4; text-decoration: underline !important;">hier</a></u>
                    <p1 style=color:#EFE3C4> terug naar inloggen.</p1>
                    <div class="card-body text-center">
                    </div>
                </div>
            </div>
        </div>
    </form>


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
        $("#updateButton").on("click", function () {

            if (!validatePasswords()) {
                return;
            }


            if ($("#ResetPasswordForm")[0].checkValidity()) {

                $.ajax({
                    url: "/UpdatePassword",
                    type: "POST",
                    data: $("#ResetPasswordForm").serialize(),
                    success: function (response) {
                        console.log(response);
                        $("#SuccesForm").show();
                        $("#ResetPasswordForm").hide();
                    },
                    error: function (xhr, status, error) {
                        alert("An error occurred: " + error);
                        console.error(xhr);
                        console.error(status);
                    }
                });
            } else {

                $("#ResetPasswordForm")[0].reportValidity();
            }
        });
    });
</script>


















<!--.form1 {
            display: //;
        }
        .form2 {
            display: //<?php echo $displayForm1 ? 'none' : 'block'; ?>;
        }-->