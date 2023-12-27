<?php
//TODO 1: wat als de user niet is ingelogd, een winkelwagentje met producten heeft en dan inlogt? wat gebeurt er met de toegevoegde producten?
//TODO 1: bij het openen van de winkelwagen na het inloggen, check of er ook een winkelwagen bestaat voor de sessionUserGuid; zo ja, dan deze producten aan winkelwagen voor userId toevoegen?

//TODO 2:
?>

<style>
    .cart-product-thumbnail {
        max-width: 10vh;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12 mt-3">
            <?php
            if (is_null($data)) {
                ?>
                <p class="text-sixth-beige">Er zijn nog geen producten aan de winkelwagen toegevoegd, klik <a
                            class="text-decoration-none" href="/Category">hier</a> om verder te winkelen</p>
                <?php
            } else {
                ?>
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="card rounded-4 p-2 bg-sixth-black text-sixth-beige">
                            <h1 class="text-sixth-beige">Winkelwagen</h1>
                            <?php
                            foreach ($data->items as $shoppingCartItem) {
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="w-100">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th><strong>Product</strong></th>
                                                <th><strong>Aantal</strong></th>
                                                <th><strong>Prijs</strong></th>
                                                <th><strong>Totaal</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <a href="/Product/<?= $shoppingCartItem->product->id ?>">
                                                        <img class="cart-product-thumbnail"
                                                             src="<?= $shoppingCartItem->product->media->thumbnail->url ?? "" ?>"
                                                             alt="<?= $shoppingCartItem->product->media->thumbnail->title ?? "" ?>"/>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="text-decoration-none"
                                                       href="/Product/<?= $shoppingCartItem->product->id ?>">
                                                        <strong><?= $shoppingCartItem->product->name ?></strong>
                                                    </a>
                                                    <br/>
                                                    <small>Artikelcode: <?= $shoppingCartItem->product->sku ?></small>
                                                </td>
                                                <td>
                                                    <select class="form-select w-auto sixth-select">
                                                        <?php
                                                        //TODO: max amount voor product ophalen?

                                                        for ($i = 1; $i <= 10; $i++) {
                                                            ?>
                                                            <option <?= $shoppingCartItem->quantity == $i ? "selected": "" ?> value="<?= $i ?>"><?= $i ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <?php
                                                    //TODO: voor number_format de bestaande functie gebruiken (komt uit branch categorie_pagina)
                                                    ?>

                                                    €<?= number_format($shoppingCartItem->product->unitPrice, 2, ",", ".") ?></td>
                                                <td>€<?= number_format($shoppingCartItem->totalPriceIncludingTax, 2, ",", ".") ?></td>
                                                <td><span class="cursor-pointer" data-item-id="<?= $shoppingCartItem->id ?>" onclick="deleteShoppingCartItem(this)">X</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-12">
                                        <hr/>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="card rounded-4 p-2 bg-sixth-black text-sixth-beige">
                            <h1 class="text-sixth-beige">Totaal</h1>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <span>Subtotaal (inclusief BTW)</span>
                                    <span>€<?= number_format($data->totalPriceIncludingTax, 2, ",", ".") ?></span>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <span>Verzendkosten</span>
                                    <span>gratis</span>
                                </div>
                                <div class="col-12">
                                    <hr />
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <span><strong>Totaalprijs (inclusief BTW)</strong></span>
                                    <span>€<?= number_format($data->totalPriceIncludingTax, 2, ",", ".") ?></span>
                                </div>
                                <div class="col-12 mt-3">
                                    <?php
                                    //TODO: button styling! (en ook h1's en card backgrounds!)
                                    ?>
                                    <button class="btn btn-primary rounded-4 sixth-button">Bestellen</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<script>
    function deleteShoppingCartItem(element) {
        var deleteConfirmed = confirm('Weet je zeker dat je dit product wilt verwijderen?');
        if(deleteConfirmed) {
            var id = $(element).data('item-id');

            $.post('/ShoppingCart/DeleteItem', { "id": id }, function(response) {
                if(response.success) {
                    window.location.reload();
                } else {
                    alert('Product verwijderen mislukt');
                }
            });
        }
    }
</script>