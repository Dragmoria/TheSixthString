$(document).ready(function () {
    $("#logoutButton").on("click", function () {
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
    });
  });