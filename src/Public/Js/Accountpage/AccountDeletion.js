$(document).ready(function () {

    $("#deleteAccountBtn").on("click", function (event) {
      event.preventDefault();

      $.ajax({
        type: "POST",
        url: "/deleteAccount",
        success: function (response) {
          window.location.href = "/AccountDeleted";
        },
        error: function (xhr, status, error) {
          console.error("Error deleting account:", status, error);
        }
      });
    });
  });
