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

    .line-hyper {
    content: "";
    display: block;
    width: calc(10 * 0.18 * 1em);
    max-width: 100%;
    border-bottom: 0.1em solid #EFE3C4;
    margin-left: 6.2rem;

  }
</style>

<div id="AccountDeleted" class="container-fluid col-12 d-flex mb-5 mt-5 justify-content-center">
    <form id="SuccesForm" style="display: block">
        <div id="accountCard" class="card bg-card-custom d-inline-block" style="position: relative; margin-top: 0px;">
            <div class="row text-center">
                <h1 style=color:#EFE3C4>Gelukt!</h1>
                <div class="col-12">
                    <p1 style=color:#EFE3C4>Uw account is verwijderd.</p1>
                    <br>
                    <p1 style=color:#EFE3C4>Ga</p1><a href="/" class="text-decoration-none" style="color:#EFE3C4">  hier 
                    </a><p1 style=color:#EFE3C4>terug naar de homepagina.</p1>
                    <div class="mb-3 line-hyper"></div>
                    <div class="card-body text-center">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>