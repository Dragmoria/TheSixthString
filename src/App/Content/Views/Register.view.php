<h1 style="color:white">Home</h1>
<p style="color:white">kiek</p>
<?$date = date("Y-m-d");
?>





<form class = "ms-auto me-auto mb-5 card p-1 bg-light" style=width:1200px;>
<div class="container">
    <div class="col-auto ms-4 mb-3">
                <h1>Registratie</h1>
                <div class="spacer"></div>
                <div class="spacer"></div>
                <h3>Persoonlijke gegevens</h3>
                <div class="spacer"></div>
                <p>Aanhef</p>
                <div class="form-check-inline">
                    <div class="col-auto form-check form-check-inline">
                        <input class="custom-control-input form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                        <label class="form-check-label" for="inlineRadio1">Mevrouw</label>
                    </div>
                    <div class="col-auto form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                        <label class="form-check-label" for="inlineRadio2">De heer</label>
                    </div>
                    <div class=" col-auto form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                    <label class="form-check-label" for="inlineRadio3">Anders</label>
                    </div>
            </div>
    </div>  
</div>
    <div class="container">
        <div class="row">
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill" id="firstName" placeholder="Voornaam">
            </div>
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill" id="middleName" placeholder="Tussenvoegsel">
            </div>
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill" id="lastName" placeholder="Achternaam">
            </div>
        </div>
        <div class="row">
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill" id="postcode" placeholder="Postcode">
            </div>
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill" id="houseNumber" placeholder="Huisnummer">
            </div>
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill" id="addition" placeholder="Toevoeging">
            </div>
        </div>
        <div class="row">
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill" id="street" placeholder="Straat">
            </div>
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill" id="postalCode" placeholder="Postcode">
            </div>
            <div class="col-3 ms-4 mb-3">
                    <select class="form-select" id="country">
                        <option selected value="1">Nederland</option>
                        <option value="2">België</option>
                        <option value="3">Luxemburg</option>
                    </select>
            </div>
        </div>
        <div class="row">
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill" id="phoneNumber" placeholder="Telefoonnummer">
            </div>
            <div class="col-3 ms-4 mb-3">
                    <input class="form-control rounded-pill" type="date" id="birthdate" value=<?echo $date?> min="1900-01-01" max="2050-12-31" />
            </div>
        </div>
    </div>
    <div class="container">
    <div class="spacer"></div>
    <div class="col-3 ms-4 mb-3">
    <h2>Inlog gegevens</h2>
    </div>
    <div class="spacer"></div>
    <div class="row">
            <div class="col-3 ms-4 mb-3">
                    <input type="text" class="form-control rounded-pill form-check-inline" id="firstName" placeholder="Email">
            </div>
            <div class="col-3 ms-4 mb-3">
                    <input type="Password" class="form-control rounded-pill form-check-inline" id="middleName" placeholder="Wachtwoord">
            </div>
            <div class="col-3 ms-4 mb-3">
                    <input type="Password" class="form-control rounded-pill form-check-inline" id="middleName" placeholder="Herhalen wachtwoord">
            </div>
            <div class="col-auto ms-4 mb-3">
            <button type="button" class="btn btn-primary rounded-pill form-check form-check-inline" style=background-color:#FCB716;border-color:#FCB716>Primary</button>
        </div>
</div>
</form>

