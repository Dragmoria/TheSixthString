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
  $("#saveChangeInfoButton").on("click", function () {
    
    event.preventDefault();
    
    var huisnummer = $("#housenumber").val();
    if (huisnummer !== "") {
      if (!isInteger(huisnummer)) {
        alert("Voer een geldig huisnummer in aub.");
        return;
      }
    }

    if (!validateDate()){
      return;
    }
  

  
    $.ajax({
      url: "/UpdateInfo",
      type: "POST",
      data: $("#ChangePersonalInfo").serialize(),
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