<style>
    .cart-product-thumbnail {
        max-width: 10vh;
    }
</style>

<div class="container">
    <div class="row" style="padding-top:5rem; min-height:100vh;">
        <div class="col-12 mt-3 mb-3" id="cart-content">
            <?php
            if (is_null($data)) {
                ?>
                <p class="text-sixth-beige">Er zijn nog geen producten aan de winkelwagen toegevoegd, klik <a
                            class="text-decoration-none text-sixth-yellow" href="/Category">hier</a> om verder te winkelen</p>
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
                                                <td><span class="cursor-pointer text-danger"
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
                    <?php
                    echo component(\Http\Controllers\Components\ShoppingCartTotalComponent::class, (array)$data);
                    ?>
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