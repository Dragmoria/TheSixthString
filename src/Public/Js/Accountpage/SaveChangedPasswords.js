function validatePasswords() {
    var password1 = document.getElementById('changePassword').value;
    var password2 = document.getElementById('repeatChangePassword').value;

    if (password1 !== password2) {
      alert('Wachtwoorden zijn niet hetzelfde, probeer het .');
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

    $("#saveChangePasswordButton").on("click", function () {
      event.preventDefault();

      if (!validatePasswords()) {
        return;
      }

      $.ajax({
        url: "/UpdateUserPassword",
        type: "POST",
        data: $("#ChangeEmailAndPassword").serialize(),
        success: function (response) {
          $.ajax({
            url: "/logout",
            type: "POST",
            success: function (response) {
              window.location.href = "/Login";
            },
            error: function (xhr, status, error) {
              console.error(xhr);
              console.error(status);
            }
          });
        },
        error: function (xhr, status, error) {
          console.error(xhr);
          console.error(status);
        }
      });
    });
  });