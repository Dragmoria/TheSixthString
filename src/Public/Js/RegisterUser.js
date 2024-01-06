
function validatePasswords() {
    var password1 = document.getElementById('password').value;
    var password2 = document.getElementById('repeatPassword').value;


    if (password1 !== password2) {
        alert('wachtwoorden zijn niet hezelfde, probeer het opnieuw.');
        return false;
    }

    var regexLength = /.{6,}/;
    var regexCapital = /[A-Z]/;
    var regexRegular = /[a-z]/;
    var regexNumber = /[0-9]/;

    if (!regexLength.test(password1) || !regexCapital.test(password1) || !regexRegular.test(password1) || !regexNumber.test(password1)) {
        alert("Wachtwoord moet ten minste 6 tekens bevatten, inclusief ten minste 1 hoofdletter, 1 kleine letter en 1 cijfer.");
        return false;
    }

    return true;
}

function validateEmails() {
    var email1 = document.getElementById('email').value;
    var email2 = document.getElementById('repeatEmail').value;

    if (email1 !== email2) {
        alert('Emailaddressen zijn niet hetzelfde, probeer het opnieuw.');
        return false;
    }
    return true;
}

function isInteger(value) {
    return /^\d+$/.test(value);
}

function validateDate() {
    var selectedDate = document.getElementById('birthdate').value;
    var minDate = new Date('1900-01-01');
  
    if (new Date(selectedDate) < minDate) {
      alert('Selecteer een geldige datum na 01-01-1900');
      return false;
    }
    return true; 
  }


$(document).ready(function () {
    $("#saveButton").on("click", function () {

        if (!validateDate()){
            return;
          }

        var huisnummer = $("#housenumber").val();
        if (!isInteger(huisnummer)) {
            alert("Voer een geldig huisnummer in aub.");
            return;
        }

        if (!validateEmails()) {
            return;
        }

        if (!validatePasswords()) {
            return;
        }


        if ($("#registerForm")[0].checkValidity()) {

            $.ajax({
                url: "/RegisterValidate",
                type: "POST",
                data: $("#registerForm").serialize(),
                success: function (response) {
                    var myForm = $("#registerForm");
                    myForm.hide();

                    var successMessage = $("#successMessageRegister");
                    successMessage.show();

                    var MyCard = $("#registrationCard")
                    var MyContainer = $("#RegisterPageContainer")

                    MyCard.removeClass("bg-card-custom").addClass("bg-card-succes");
                },
                error: function (xhr, status, error) {

                    if (xhr.status === 409) {
                        alert("Het ingevoerde e-mailadres is al in gebruik.");
                    } else if (xhr.status === 400) {
                        alert("De ingevoerde wachtwoorden zijn niet hetzelfde.");
                    } else if (xhr.status === 406) {
                        alert("Wachtwoord moet ten minste 6 tekens bevatten, inclusief ten minste 1 hoofdletter, 1 kleine letter en 1 cijfer.");
                    } else {
                        alert("Er is iets fout gegaan, neem contact op met de beheerder.");
                        console.error(xhr);
                        console.error(status);
                    }
                }
            });
        } else {

            $("#registerForm")[0].reportValidity();
        }
    });
});