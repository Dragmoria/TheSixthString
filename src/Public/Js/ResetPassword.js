$("#succesForm").hide();



function validatePasswords() {
    var password1 = document.getElementById('password').value;
    var password2 = document.getElementById('repeatPassword').value;

    if (password1 !== password2) {
        alert('wachtwoorden zijn niet hezelfde, probeer het opnieuw..');
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

$(document).ready(function () {
    $("#updateButton").on("click", function () {

        if (!validatePasswords()) {
            return;
        }


        if ($("#ResetPasswordForm")[0].checkValidity()) {

            $.ajax({
                url: "/UpdatePassword/" + link,
                type: "POST",
                data: $("#ResetPasswordForm").serialize(),
                success: function (response) {
                    console.log(response);
                    $("#SuccesForm").show();
                    $("#ResetPasswordForm").hide();
                },
                error: function (xhr, status, error) {

                    console.error(xhr);
                    console.error(status);
                }
            });
        } else {

            $("#ResetPasswordForm")[0].reportValidity();
        }
    });
});