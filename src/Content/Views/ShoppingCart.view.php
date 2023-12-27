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
                                                    <a class="text-decoration-none text-sixth-yellow"
                                                       href="/Product/<?= $shoppingCartItem->product->id ?>">
                                                        <strong><?= $shoppingCartItem->product->name ?></strong>
                                                    </a>
                                                    <br/>
                                                    <small>Artikelcode: <?= $shoppingCartItem->product->sku ?></small>
                                                </td>
                                                <td>
                                                    <select class="form-select w-auto sixth-select" data-product-id="<?= $shoppingCartItem->product->id ?>"
                                                            onchange="changeQuantity(this)">
                                                        <?php
                                                        for ($i = 1; $i <= $shoppingCartItem->product->amountInStock; $i++) {
                                                            ?>
                                                            <option <?= $shoppingCartItem->quantity == $i ? "selected" : "" ?>
                                                                    value="<?= $i ?>"><?= $i ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <?= formatPrice($shoppingCartItem->product->unitPrice) ?></td>
                                                <td>
                                                    <?= formatPrice($shoppingCartItem->totalPriceIncludingTax) ?></td>
                                                <td><span class="cursor-pointer"
                                                          data-item-id="<?= $shoppingCartItem->id ?>"
                                                          onclick="deleteShoppingCartItem(this)">X</span></td>
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
                                    <span><?= formatPrice($data->totalPriceIncludingTax) ?></span>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <span>Verzendkosten</span>
                                    <span>gratis</span>
                                </div>
                                <div class="col-12">
                                    <hr/>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <span><strong>Totaalprijs (inclusief BTW)</strong></span>
                                    <span><?= formatPrice($data->totalPriceIncludingTax) ?></span>
                                </div>
                                <div class="col-12 mt-3">
                                    <?php
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
        if (deleteConfirmed) {
            var id = $(element).data('item-id');

            $.post('/ShoppingCart/DeleteItem', {"id": id}, function (response) {
                if (response.success) {
                    window.location.reload();
                } else {
                    alert('Product verwijderen mislukt');
                }
            });
        }
    }

    function changeQuantity(element) {
        var productId = $(element).data('product-id');

        $.post('/ShoppingCart/ChangeQuantity', {
            "productId": productId,
            "quantity": $(element).val()
        }, function (response) {
            if (response.success) {
                window.location.href = '/ShoppingCart';
            } else {
                var message = response.message;
                if (response.message == '') {
                    response.message = 'Aantal wijzigen mislukt';
                }

                alert(message);
            }
        });
    }
</script>