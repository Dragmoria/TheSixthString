document.addEventListener("DOMContentLoaded", function () {

    function toggleFormsAndChangeIcon(showInfoForm, showChangePersonalInfo, showOrderHistory) {
      const accountCard = document.getElementById("accountCard");
      const infoForm = accountCard.querySelector("#InfoForm");
      const changePersonalInfoForm = accountCard.querySelector("#ChangePersonalInfo");
      const ChangeEmailAndPasswordForm = accountCard.querySelector('#ChangeEmailAndPassword');
      const orderHistory = accountCard.querySelector("#orderHistory");
      const accountIcon = document.getElementById("accountIcon");
      const changeText = accountCard.querySelector('#InfoUpdatedText');


      infoForm.style.display = showInfoForm ? "block" : "none";
      changePersonalInfoForm.style.display = showChangePersonalInfo ? "block" : "none";
      ChangeEmailAndPasswordForm.style.display = showChangePersonalInfo ? "block" : "none";
      orderHistory.style.display = showOrderHistory ? "block" : "none";
      changeText.style.display = "none";

      if (showInfoForm) {
        accountIcon.className = "bi bi-person-vcard-fill custom-icon-size";
      } else if (showChangePersonalInfo) {
        accountIcon.className = "bi bi-person-fill-gear custom-icon-size";
      } else if (showOrderHistory) {
        accountIcon.className = "bi bi-collection-fill custom-icon-size";
      }
    }

    const infoButton = document.getElementById("infoButton");
    const changeInfoButton = document.getElementById("changeInfoButton");
    const orderHistoryButton = document.getElementById("orderHistoryButton");



    infoButton.addEventListener("click", function () {
      toggleFormsAndChangeIcon(true, false, false);
    });

    changeInfoButton.addEventListener("click", function () {
      toggleFormsAndChangeIcon(false, true, false);
    });

    orderHistoryButton.addEventListener("click", function () {
      toggleFormsAndChangeIcon(false, false, true);
    });
  });