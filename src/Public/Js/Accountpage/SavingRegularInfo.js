  $(document).ready(function () {
    $("#saveChangeInfoButton").on("click", function () {
      event.preventDefault();

      var additionalData = {
        key: 'infoUpdated'
      };

      var serializedData = $("#ChangePersonalInfo").serialize();
      var combinedData = serializedData + '&' + $.param(additionalData);

      $.ajax({
        url: "/UpdateInfo",
        type: "POST",
        data: combinedData,
        success: function (response) {

          window.location.href = "/Account";

        },
        error: function (xhr, status, error) {
          console.error(xhr);
          console.error(status);
        }
      });
    });
  });