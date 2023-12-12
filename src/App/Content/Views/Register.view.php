<style> 
    body{
    
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
      </style>
    
    
    <h1 style="color:#2C231E">Home</h1>
    <p style="color:#2C231E">kiek</p>
    <?$date = date("Y-m-d");
    $spacer = '<div class="spacer"></div>';
    $fields = array(
        'Voornaam' => 'firstname',
        'Tussenvoegsel' => 'middlename',
        'Achternaam' => 'lastname',
        'Postcode' => 'zipcode',
        'Huisnummer' => 'housenumber',
        'Toevoeging' => 'addition',
        'Straat' => 'street',
        'Plaats' => 'city',
        'Telefoonnummer' => 'phonenumber',
    );
    
    
    ?>
    
    
    
    
    
    <form class="ms-auto me-auto mb-5 card p-1 bg-card-custom" style="width: 1200px;" method="POST" action="/Register">
    <div class="container">
        <div class="col-auto mt-4 ms-4 mb-3">
                <h1 style="color:#EFE3C4">Registratie</h1>
                <?= $spacer . $spacer ?>
                <h3 style="color:#EFE3C4">Persoonlijke gegevens</h3>
                <div class="spacer"></div>
                <p style="color:#EFE3C4">Aanhef</p>
                <div class="form-check-inline">
                    <?php foreach (['Mevrouw', 'De heer', 'Anders'] as $option): ?>
                        <div class="col-auto form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="<?= strtolower($option) ?>" value="<?= strtolower($option) ?>">
                            <label style="color:#EFE3C4" class="form-check-label" for="<?= strtolower($option) ?>"><?= $option ?></label>
            </div>
        <?php endforeach; ?>
    </div>
</div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php foreach ($fields as $label => $name): ?>
                <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill bg-beige-color" id="<?= $name ?>" name="<?= $name ?>" placeholder="<?= $label ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Additional rows and fields go here -->
    </div>
    <div class="container">
        <!-- Rest of your form code goes here -->
    </div>
    <div class="container">
        <div class="row">
            <div class="col-3 ms-4 mb-3">
                <input type="text" class="form-control rounded-pill bg-beige-color" id="birthdate" name="birthdate" value="<?= $date ?>" min="1900-01-01" max="2050-12-31" />
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
            <?php foreach (['email', 'wachtwoord', 'herhalen wachtwoord'] as $field): ?>
                <div class="col-3 ms-4 mb-3">
                    <input type="<?= $field === 'email' ? 'text' : 'password' ?>" class="form-control rounded-pill form-check-inline bg-beige-color" id="<?= $field ?>" name="<?= $field ?>" placeholder="<?= ucfirst($field) ?>">
                </div>
            <?php endforeach; ?>
            <div class="col-auto ms-4 mb-3">
                <button type="button" id="showPasswordButton" name="showPasswordButton" class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color" style="background-color:#FCB716;border-color:#FCB716" onmousedown="showPassword()" onmouseup="showpassword()">Wachtwoord tonen</button>
            </div>
            <div class="row">
                <div class="col-auto ms-auto mb-3 me-auto mt-4">
                    <button type="submit" id="saveButton" name="saveButton" class="btn btn-primary rounded-pill form-check form-check-inline bg-beige-color" style="background-color:#FCB716;border-color:#FCB716">Gegevens opslaan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
var repeatPasswordInput = document.getElementById('herhalen wachtwoord');
var PasswordInput = document.getElementById('wachtwoord')
var showPasswordButton = document.getElementById('showPasswordButton');


function togglePasswordVisibility() {
    if (repeatPasswordInput.type === 'password') {
        repeatPasswordInput.type = 'text';
        PasswordInput.type = 'text';
        showPasswordButton.style.transform = 'scale(1.1)';
    } else {
        showPasswordButton.style.transform = 'scale(1)';
        repeatPasswordInput.type = 'password';
        PasswordInput.type = 'password';
    }
}

showPasswordButton.addEventListener('mousedown', togglePasswordVisibility);
showPasswordButton.addEventListener('mouseup', togglePasswordVisibility);
</script>