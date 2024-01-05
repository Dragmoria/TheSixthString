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
            <div class="col-12 d-flex justify-content-between <?= $data->totalPriceIncludingTaxCouponApplied != $data->totalPriceIncludingTax ? "" : "d-none" ?>" id="discount-applied">
                <span>Korting</span>
                <span class="text-danger cursor-pointer" onclick="removeCoupon()">X</span>
                <span id="discount-amount">-<?= formatPrice($data->totalPriceIncludingTax - $data->totalPriceIncludingTaxCouponApplied) ?></span>
            </div>
            <div class="col-12">
                <hr/>
            </div>
            <div class="col-12 d-flex justify-content-between">
                <span><strong>Totaalprijs (inclusief BTW)</strong></span>
                <span id="total-price"><?= formatPrice($data->totalPriceIncludingTaxCouponApplied) ?></span>
            </div>
            <div class="col-12 mt-3">
                <?php
                ?>
                <a href="/ShoppingCart/PersonalInformation" class="btn btn-primary rounded-4 sixth-button" id="cart-button">Bestellen</a>
            </div>
        </div>
    </div>
</div>

<script>
    function removeCoupon() {
        $.post('/ShoppingCart/RemoveCoupon', function() {
            window.location.reload();
        });
    }
</script>