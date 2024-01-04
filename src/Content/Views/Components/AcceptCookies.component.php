<style>
    .cookie-modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .cookie-modal-content {
        background-color: #EFE3C4;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }
</style>

<div id="cookieModal" class="cookie-modal">
    <div class="cookie-modal-content card">
        <h2>Cookies op onze website</h2>
        <p>Wij gebruiken cookies om ervoor te zorgen dat we u de beste ervaring op onze website bieden. Als u doorgaat
            zonder uw instellingen te wijzigen, gaan we ervan uit dat u alle cookies op de website ontvangt.</p>
        <div class="col-12 text-center">
            <button class="col-2 rounded-pill"
                style="background-color:#FCB716;border-color:#FCB716" id="acceptCookies">Accept</button>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
        var modal = document.getElementById('cookieModal');
        var acceptButton = document.getElementById('acceptCookies');

        // Show the modal
        modal.style.display = "block";

        // When the user clicks on the "Accept" button, close the modal
        acceptButton.onclick = function () {
            modal.style.display = "none";
            $.ajax({
                url: '/accept-cookies',
                type: 'POST',
                data: {
                    'accept': true
                },
                success: function (response) {
                    console.log(response);
                }
            });
        }
    }
</script>