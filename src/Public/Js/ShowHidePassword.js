function togglePasswordVisibility(passwordName) {
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