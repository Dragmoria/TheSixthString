<!--- The Fold lg --->
<div class="container-fluid g-0 d-none d-lg-block">
    <div class="row g-0 header-custom" style="height: 100vh;">
        <div class="col"></div>
        <div class="col d-flex flex-column justify-content-center align-items-center text-center">
            <img src="/images/logo-big.svg" alt="Your Logo" style="max-width:50%;">
            <a href="/Product">
                <button type="button" class="btn btn-primary btn-lg mt-5 px-5 rounded-pill"
                    style="background-color: var(--sixth-beige); border-color: var(--sixth-beige); color: var(--sixth-brown); font-weight: 700 !important;">Nieuw
                    assortiment!
                </button>
            </a>
        </div>
    </div>
</div>

<!--- The Fold sm --->
<div class="container-fluid g-0 d-lg-none">
    <div class="row g-0 header-custom" style="height: calc(100vh - 140px);">
        <div class="col d-flex flex-column justify-content-center align-items-center text-center">
            <img src="/images/logo-big.svg" alt="Your Logo" style="max-width:50%;">
            <a href="/Product">
                <button type="button" class="btn btn-primary btn-lg mt-5 px-5 rounded-pill"
                    style="background-color: var(--sixth-beige); border-color: var(--sixth-beige); color: var(--sixth-brown); font-weight: 700 !important;">Nieuw
                    assortiment!
                </button>
            </a>
        </div>
    </div>
</div>

<!--- Product Card --->
<div class="container-fluid g-0 d-none d-lg-block">
    <div class="row g-0 px-5 d-flex justify-content-center align-items-center"
        style="background-color: var(--sixth-beige); border-bottom-right-radius: 25vmin; min-height:100vh;">
        <div class="row mt-5 d-flex justify-content-center align-items-center" style="height:10%;">
            <div class="col-3">
                <hr style="height:2px;border:none;color:var(--sixth-black);background-color:var(--sixth-black);" />
            </div>
            <div class="col text-center">
                <h2>🞄
            </div>
            <div class="col-4 text-center">
                <h2><strong>Populaire producten</strong></h2>
            </div>
            <div class="col text-center">
                <h2>🞄
            </div>
            <div class="col-3">
                <hr style="height:2px;border:none;color:var(--sixth-black);background-color:var(--sixth-black);" />
            </div>
        </div>
        <div class="row my-3 d-flex justify-content-center align-items-center">
            <?php foreach ($products as $product) { ?>
            <div class="col-2 mx-2">
                <?php
                echo component(\Http\Controllers\Components\ProductCardComponent::class, (array) $product);
                ?>
            </div>
            <?php
            }
            ?>
        </div>
        <div class="row mb-5 d-flex justify-content-center align-items-top" style="height:10%;">
            <div class="col">
                <hr style="height:3px;border:none;color:var(--sixth-black);background-color:var(--sixth-black);" />
            </div>
        </div>
    </div>
</div>

<!--- Product Card sm --->
<div class="container-fluid g-0 d-lg-none">
    <div class="row g-0 px-5 d-flex justify-content-center align-items-center"
        style="background-color: var(--sixth-beige); border-bottom-right-radius: 25vmin; min-height:100vh;">
        <div class="row mt-5 d-flex justify-content-center align-items-center" style="height:10%;">
            <div class="col text-center">
                <h2><strong>Populair product!</strong></h2>
            </div>
        </div>
        <div class="row my-3 d-flex justify-content-center align-items-center">
            <div class="col-8 mx-2">
                <?php
                echo component(\Http\Controllers\Components\ProductCardComponent::class, (array) $products[rand(0, 4)]);
                ?>
            </div>
        </div>
    </div>
</div>

<!--- About & Discover sm --->
<div class="container-fluid g-0 d-none d-lg-block">
    <div style="background-color: var(--sixth-beige);">
        <div style="background-color: var(--sixth-brown); min-height: 100vh; border-top-left-radius: 20vmin;">
            <div class="row g-0 py-5 justify-content-center align-items-center">
                <div class="col-6 d-flex justify-content-center align-items-center" style="color: var(--sixth-beige);">
                    <div style="max-width:70%;">
                        <p class="h3">Ontdekt The Sixth String</p>
                        <p class="fs-5">Waar muzikale magie begint. Van klassieke akoestieken tot elektrische
                            krachtpatsers, vind
                            de perfecte gitaar die jouw unieke verhaal vertelt. Onze virtuele winkel biedt niet alleen
                            topkwaliteit instrumenten, maar ook deskundig advies voor jouw perfecte match.
                            Laat je inspireren door de nieuwste modellen en ontdek accessoires die jouw speelervaring
                            verbeteren.
                            "The Sixth String" is niet zomaar een gitaarshop; het is jouw toegangspoort tot een wereld
                            van klank
                            en stijl.
                        </p>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <img src="images/discover-image.png" alt="Your Logo" style="max-width:80%;">
                </div>
            </div>
            <div class="row g-0 py-5 justify-content-center align-items-center">
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <img src="images/about-image.jpg" alt="Your Logo" style="max-width:80%;">
                </div>
                <div class="col-6 d-flex justify-content-center align-items-center" style="color: var(--sixth-beige);">
                    <div style="max-width:70%;">
                        <p class="h3">Maar wie zijn wij eigenlijk?</p>
                        <p class="fs-5">Met onze wortels diep verankerd in de dynamische wereld van muziek, beheren we
                            met trots
                            zowel fysieke winkels als een online platform in de Benelux.
                            Onze missie is simpel: hoogwaardige gitaren, accessoires en professionele diensten leveren
                            aan alle
                            gitaristen. Gedreven door een liefde voor muziek streven we ernaar om via ons online
                            platform en
                            zorgvuldig samengestelde selectie een naadloze muziekervaring te bieden.
                            Ontdek The Sixth String en laat de muziekreis beginnen.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--- About & Discover lg --->
<div class="container-fluid g-0 d-lg-none">
    <div style="background-color: var(--sixth-beige);">
        <div style="background-color: var(--sixth-brown); min-height: 100vh; border-top-left-radius: 20vmin;">
            <div class="row g-0 py-5 flex-column justify-content-center align-items-center">
                <div class="col d-flex justify-content-center align-items-center" style="color: var(--sixth-beige);">
                    <div style="max-width:70%;">
                        <p class="h3 text-center">Ontdekt The Sixth String</p>
                        <p class="fs-5 text-center">Waar muzikale magie begint. Van klassieke akoestieken tot
                            elektrische
                            krachtpatsers, vind
                            de perfecte gitaar die jouw unieke verhaal vertelt. Onze virtuele winkel biedt niet alleen
                            topkwaliteit instrumenten, maar ook deskundig advies voor jouw perfecte match.
                            Laat je inspireren door de nieuwste modellen en ontdek accessoires die jouw speelervaring
                            verbeteren.
                            "The Sixth String" is niet zomaar een gitaarshop; het is jouw toegangspoort tot een wereld
                            van klank
                            en stijl.
                        </p>
                    </div>
                </div>
                <div class="col d-flex justify-content-center align-items-center">
                    <img src="images/discover-image.png" alt="Your Logo" style="max-width:80%;">
                </div>
            </div>
            <div class="row g-0 py-5 flex-column justify-content-center align-items-center">
                <div class="col d-flex justify-content-center align-items-center" style="color: var(--sixth-beige);">
                    <div style="max-width:70%;">
                        <p class="h3 text-center">Maar wie zijn wij eigenlijk?</p>
                        <p class="fs-5 text-center">Met onze wortels diep verankerd in de dynamische wereld van muziek,
                            beheren we
                            met trots
                            zowel fysieke winkels als een online platform in de Benelux.
                            Onze missie is simpel: hoogwaardige gitaren, accessoires en professionele diensten leveren
                            aan alle
                            gitaristen. Gedreven door een liefde voor muziek streven we ernaar om via ons online
                            platform en
                            zorgvuldig samengestelde selectie een naadloze muziekervaring te bieden.
                            Ontdek The Sixth String en laat de muziekreis beginnen.
                        </p>
                    </div>
                </div>
                <div class="col d-flex justify-content-center align-items-center">
                    <img src="images/about-image.jpg" alt="Your Logo" style="max-width:80%;">
                </div>
            </div>
        </div>
    </div>
</div>