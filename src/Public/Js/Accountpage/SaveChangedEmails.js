function isValidEmail(email) {

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  function validateEmails() {
    var email1 = document.getElementById('email').value;
    var email2 = document.getElementById('repeatEmail').value;

    if (email1 !== email2) {
      alert('E-mailadressen zijn niet hetzelfde, probeer het opnieuw.');
      return false;
    }

    return true;
  }

  
  $(document).ready(function () {
    $("#saveChangeEmailButton").on("click", function () {
      event.preventDefault();

      if (!validateEmails()) {
        return;
      }

      const emailAddress = document.getElementById('email').value;
      if (!isValidEmail(emailAddress)) {
        alert('Het ingevoerde emailadres is niet geldig.');
        return;
      }

      $.ajax({
        url: "/UpdateEmail",
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