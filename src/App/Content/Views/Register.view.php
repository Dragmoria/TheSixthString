<style> 
body{
    background-color: #2C231E;
}
label {
    display: block;
    font:
      1rem 'Fira Sans',
      sans-serif;
}
      input,button,
  label {
    margin: 0.2rem 0;
  }

  input[type="radio"]:checked{
    background-color: #FCB716;

  }
  input[type="text"]{
    background-color:#EFE3C4;
    border-color:#EFE3C4
  }
  input[class="form-control rounded-pill"]{
    background-color:#EFE3C4;
    border-color:#EFE3C4
  }
  input[type="password"]{
    background-color:#EFE3C4;
    border-color:#EFE3C4
  }
  select[class="form-select"]{
    background-color:#EFE3C4;
    border-color:#EFE3C4
  }
  .bg-custom{
    background-color: #1C1713;
  }
  </style>


<h1 style="color:#2C231E">Home</h1>
<p style="color:#2C231E">kiek</p>
<?$date = date("Y-m-d");
?>





<form class = "ms-auto me-auto mb-5 card p-1 bg-custom" style=width:1200px;>
<div class="container">
    <div class="col-auto ms-4 mb-3">
                <h1 style="color:#EFE3C4">Registratie</h1>
                <div class="spacer"></div>
                <div class="spacer"></div>
                <h3 style="color:#EFE3C4">Persoonlijke gegevens</h3>
                <div class="spacer"></div>
                <p style="color:#EFE3C4">Aanhef</p>
                <div class="form-check-inline">
                    <div class="col-auto form-check form-check-inline">
                        <input class="custom-control-input form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                        <label style="color:#EFE3C4" class="form-check-label" for="inlineRadio1">Mevrouw</label>
                    </div>
                    <div class="col-auto form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                        <label style="color:#EFE3C4" class="form-check-label" for="inlineRadio2">De heer</label>
                    </div>
                    <div class=" col-auto form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                    <label style="color:#EFE3C4" class="form-check-label" for="inlineRadio3">Anders</label>
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
    <h2 style="color:#EFE3C4">Inlog gegevens</h2>
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
            <button type="button"  class="btn btn-primary rounded-pill form-check form-check-inline" style=background-color:#FCB716;border-color:#FCB716>Wachtwoord tonen</button>
        </div>
        <div class="row">
            <div class="col-auto ms-auto mb-3 me-auto mt-4">
            <button type="button"  class="btn btn-primary rounded-pill form-check form-check-inline" style=background-color:#FCB716;border-color:#FCB716>Gegevens opslaan</button>
        </div>
</div>
</form>

