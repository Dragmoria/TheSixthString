
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<style> 
    body{
    background-color: #2C231E;
    }
    
     
      input[type="radio"]:checked{
        background-color: #FCB716;
        border-color: #FCB716 ;
        box-shadow: 0 0 0 0rem #FCB716
      }
      input[type="radio"]:focus{
        border-color: #FCB716 ;
        box-shadow: 0 0 0 0rem #FCB716
      }
    
      .bg-beige-color{
        background-color:#EFE3C4;
        border-color:#EFE3C4
      }
      .bg-beige-color:focus,select:focus{
        border-color:#FCB716;
        box-shadow: 0 0 0 0.2rem #FCB716;
    
      }
      .bg-card-custom{
       background-color: #1C1713;
      }

      .password-container {
        position: relative;
        
    }

    .password-input {
        
    }

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
    <?$date = date("Y-m-d");
    $spacer = '<div class="spacer"></div>';
    $fields = array(
        'Voornaam' => array('name' => 'firstname', 'importance' => 'required'),
        'Tussenvoegsel *' => array('name' => 'middlename', 'importance' => 'notrequired'),
        'Achternaam' => array('name' => 'lastname', 'importance' => 'required'),
        'Postcode' => array('name' => 'zipcode', 'importance' => 'required'),
        'Huisnummer' => array('name' => 'housenumber', 'importance' => 'required'),
        'Toevoeging *' => array('name' => 'addition', 'importance' => 'notrequired'),
        'Straat' => array('name' => 'street', 'importance' => 'required'),
        'Plaats' => array('name' => 'city', 'importance' => 'required'),
        'Telefoonnummer *' => array('name' => 'phonenumber', 'importance' => 'notrequired'),
    );
    
    ?>
    
    
    
    
    
    <form class="ms-auto me-auto mb-5 card p-1 bg-card-custom" style="width: 1200px;" method="POST" action="/Register" onsubmit="return validatePasswords()">
    <div class="container">
        <div class="col-auto mt-4 ms-4 mb-3">
                <h1 style="color:#EFE3C4">Registratie</h1>
                <?= $spacer . $spacer ?>
                <h3 style="color:#EFE3C4">Persoonlijke gegevens</h3>
                <div class="spacer"></div>
                <p style="color:#EFE3C4">Aanhef</p>
                    <?php foreach (['Mevrouw'=> 'female', 'De heer' => 'male', 'Anders' => 'else'] as $label => $name): ?>
                        <div class="col-auto form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="<?= $name ?>" value="<?php echo $label; ?>" required>
                            <label style="color:#EFE3C4" class="form-check-label" for="<?= $label ?>"><?= $label ?></label>
            </div>
        <?php endforeach; ?>
</div>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="row">
        <?php foreach ($fields as $label => $field): ?>
            <div class="col-3 ms-4 mb-3">
                <input type="form-check-text" class="form-control rounded-pill bg-beige-color" id="<?= $field['name'] ?>" name="<?= $field['name'] ?>" placeholder="<?php echo $label; ?>" <?php echo ($field['importance'] === 'required') ? 'required' : ''; ?>>
            </div>
        <?php endforeach; ?>
    </div>
</div>
    <div class="container">
        <!-- Rest of your form code goes here -->
    </div>
    <div class="container">
        <div class="row">
        <div class="col-3 ms-4 mb-3">
                        <select class="form-select rounded-pill bg-beige-color" id="country" name="country" required>
                            <option value="" disabled selected>Selecteer land</option>
                            <option value="1">Nederland</option>
                            <option value="2">België</option>
                            <option value="3">Luxemburg</option>
                        </select>
                </div>
            <div class="col-3 ms-4 mb-3">
                <input type="date" class="form-control rounded-pill bg-beige-color" id="birthdate" name="birthdate" min="1900-01-01" max="2050-12-31" / required>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-3 ms-4 mb-3">
            <i><p style="color:#EFE3C4">* is niet verplicht</p></i>
        </div>
        <div class="spacer"></div>
        <div class="col-3 ms-4 mb-3">
            <h2 style="color:#EFE3C4">Inlog gegevens</h2>
        </div>
        <div class="spacer"></div>
        <div class="row">
    <?php foreach (['Email' => 'email', 'Wachtwoord' => 'password', 'Herhalen wachtwoord' => 'repeatPassword'] as $label => $name): ?>
        <div class="col-3 ms-4 mb-3">
            <?php if ($name === 'password' || $name === 'repeatPassword'): ?>
                <div class="password-container">
                    <input type="<?= $label === 'email' ? 'text' : 'password' ?>" class="form-control rounded-pill bg-beige-color password-input" id="<?= $name ?>" name="<?= $name ?>" placeholder="<?= $label ?>" required>
                    <i class="bs bi-eye-slash-fill toggle-eye"  onclick="togglePasswordVisibility('<?= $name ?>')"></i>
                </div>
            <?php else: ?>
                <input type="text" class="form-control rounded-pill form-check-inline bg-beige-color" id="<?= $name ?>" name="<?= $name ?>" placeholder="<?= $label ?>" required>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <div class="col-auto ms-4 mb-5">
    <button type="submit" id="saveButton" name="saveButton" class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color" value="<?php echo $label; ?>" style="background-color:#FCB716;border-color:#FCB716">Gegevens opslaan</button>    </div>
</div>
</div>
</form>

<script>
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


function togglePasswordVisibility(passwordName) {
    var repeatPasswordInput = document.getElementById('repeatPassword');
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
</script>