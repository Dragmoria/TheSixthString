<?php
$componentFile = \Http\Controllers\Components\CategoryListComponent::class;
?>

<!-- Footer large screens -->
<div class="d-none d-lg-block">
    <div class="container-fluid flex-column" style="background-color: var(--sixth-black);">
        <div style="height: 5vh;">
        </div>

        <div class="row mx-3 my-5">
            <div class="col">
            </div>
            <!-- Categorieën -->
            <div class="col">
                <h5 style="color: var(--sixth-yellow);">
                    <a href="/Category" class="text-decoration-none text-sixth-yellow">Categorieën</a>
                </h5>
                <?php $componentFile ?>
            </div>

            <!-- Service -->
            <div class="col">
                <h5 style="color: var(--sixth-yellow);">Service</h5>
                <ul class="list-unstyled text-sixth-beige">
                    <p class="m-0" href="#">Contact</p>
                    <p class="m-0" href="#">Retourneren</p>
                    <p class="m-0" href="#">Garantie</p>
                </ul>
            </div>

            <!-- Overig -->
            <div class="col">
                <h5 style="color: var(--sixth-yellow);">Overig</h5>
                <ul class="list-unstyled text-sixth-beige">
                    <p class="m-0" href="#">Algemene Voorwaarden</p>
                    <p class="m-0" href="#">Disclaimer</p>
                    <p class="m-0" href="#">Privacy Policy</p>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="col-md-2">
                <h5 style="color: var(--sixth-yellow);">Volg ons</h5>
                <div class="d-flex justify-content-between">
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\facebook.png" alt="F" width="17" height="17">
                    </button>
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\x.png" alt="X" width="17" height="17">
                    </button>
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\instagram.png" alt="I" width="17" height="17">
                    </button>
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\youtube.png" alt="Y" width="17" height="17">
                    </button>
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\pintrest.png" alt="P" width="17" height="17">
                    </button>
                </div>
            </div>

            <div class="col">
            </div>

            <!-- Logo -->
            <div class="col-md-3">
                <img src="\images/logo-big.svg" alt="Logo" class="img-fluid">
            </div>

            <div class="col">
            </div>
        </div>

        <div style="height: 5vh;">
        </div>
    </div>
    <!-- Copyright Bar -->
    <div class="container-fluid d-flex justify-content-center align-items-center text-center text-sixth-beige"
        style="height: 50px; background-color: #000000; font-size: 10px; opacity: 0.6;">
        <p class="m-0">Algemene Copyright © The Sixth String 2023 / Alle prijzen zijn inclusief 21% BTW, tenzij anders
            vermeld</p>
    </div>
</div>

<!-- Footer small screens -->
<div class="d-lg-none">
    <div class="container-fluid flex-column" style="background-color: var(--sixth-black);">
        <div class="row">

            <div class="col-12 py-3 d-flex justify-content-center align-items-center" style="color: var(--sixth-yellow); border-bottom: var(--sixth-brown) 1px solid;">
                <h5 style="color: var(--sixth-yellow);">Categorieën</h5>
            </div>

            <!-- Service -->
            <div class="col-12 py-3 d-flex justify-content-center align-items-center" style="color: var(--sixth-yellow); border-bottom: var(--sixth-brown) 1px solid;">
                <h5 style="color: var(--sixth-yellow);">Service</h5>
            </div>

            <!-- Overig -->
            <div class="col-12 py-3 d-flex justify-content-center align-items-center" style="color: var(--sixth-yellow); border-bottom: var(--sixth-brown) 1px solid;">
                <h5 style="color: var(--sixth-yellow);">Overig</h5>
            </div>

            <!-- Social Media -->
            <div class="col-12 py-3" style="border-bottom: var(--sixth-brown) 1px solid;">
                <h5 class="d-flex justify-content-center align-items-center" style="color: var(--sixth-yellow);">Volg ons</h5>
                <div class="pt-1 d-flex justify-content-center align-items-center">
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\facebook.png" alt="F" width="17" height="17">
                    </button>
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\x.png" alt="X" width="17" height="17">
                    </button>
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\instagram.png" alt="I" width="17" height="17">
                    </button>
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\youtube.png" alt="Y" width="17" height="17">
                    </button>
                    <button
                        class="btn mx-2 btn-primary rounded-circle d-flex align-items-center justify-content-center footer-button">
                        <img src="\images\social-icons\pintrest.png" alt="P" width="17" height="17">
                    </button>
                </div>
            </div>
            <div style="height: 5vh;" ></div>
            <!-- Logo -->
            <div class="col-12 d-flex justify-content-center align-items-center">
                <img src="\images/logo-big.svg" alt="Logo" class="img-fluid" style="max-width: 60%;">
            </div>
            <div style="height: 5vh;" ></div>
        </div>
    </div>
    <!-- Copyright Bar -->
    <div class="container-fluid d-flex justify-content-center align-items-center text-center text-sixth-beige"
        style="height: 50px; background-color: #000000; font-size: 10px; opacity: 0.6;">
        <p class="m-0">Algemene Copyright © The Sixth String 2023 / Alle prijzen zijn inclusief 21% BTW, tenzij
            anders
            vermeld</p>
    </div>
</div>