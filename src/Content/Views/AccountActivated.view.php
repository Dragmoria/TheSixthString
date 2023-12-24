<style>
    body {
        background-color: #2C231E;
    }

    .bg-beige-color {
        background-color: #EFE3C4;
        border-color: #EFE3C4
    }

    .bg-beige-color:focus,
    select:focus {
        border-color: #FCB716;
        box-shadow: 0 0 0 0.2rem #FCB716;

    }

    .bg-card-custom {
        background-color: #1C1713;
    }

    .custom-input-height {
        height: calc(3.5 * 1em);
        /* Adjust the multiplier as needed */
    }
</style>

<div id="AccountActivated" class="container-fluid col-12 d-flex mb-5 mt-4 justify-content-center">
    <form id="SuccesForm" style="display: block">
        <div id="accountCard" class="card bg-card-custom d-inline-block" style="position: relative; margin-top: 0px;">
            <div class="row text-center">
                <h1 style=color:#EFE3C4>Gelukt!</h1>
                <div class="col-12">
                    <p1 style=color:#EFE3C4>Uw account is geactiveerd, ga </p1><u><a href="/Login"
                            class="text-decoration-none"
                            style="color:#EFE3C4; text-decoration: underline !important;">hier</a></u>
                    <p1 style=color:#EFE3C4> terug naar inloggen.</p1>
                    <div class="card-body text-center">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>