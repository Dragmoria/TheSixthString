<?php
?>

<div class="container">
    <div class="row">
        <div clas="col-12 mt-3 mb-3" id="cart-content">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card rounded-4 p-2 bg-sixth-black text-sixth-beige">
                        <h1 class="text-sixth-beige">Betaalgegevens</h1>
                        <div class="row">
                            <div class="col-12">
                                <h5>Cadeaukaart/kortingscode invoeren</h5>
                                <div class="row">
                                    <div class="col-auto">
                                        <input id="coupon-input" type="text" class="form-control w-auto bg-sixth-beige" />
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" onclick="processCoupon()" class="btn btn-primary sixth-button rounded-4">Activeren</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <h5>Betaalmethode selecteren</h5>
                                <select id="payment-method" class="form-select w-auto sixth-select">
                                    <option value="">Kies een betaalmethode...</option>
                                    <?php
                                    foreach (\Lib\Enums\PaymentMethod::cases() as $paymentMethod) {
                                        ?>
                                        <option value="<?= $paymentMethod->name ?>"><?= $paymentMethod->toString() ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                echo component(\Http\Controllers\Components\ShoppingCartTotalComponent::class, (array)$data);
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cart-button').text('Betalen');
    });

    $('#cart-button').on('click', function(e) {
        e.preventDefault();

        if($('#payment-method').val() == '') {
            alert('Kies eerst een betaalmethode');
            return;
        }
        startPayment(e);
    });

    function startPayment(e) {
        if($(e.currentTarget).hasClass('disabled')) {
            return;
        }

        $(e.currentTarget).addClass('disabled');

        $.post('/ShoppingCart/StartPayment', { paymentMethod: $('#payment-method').val() }, function(response) {
            if(response.success) {
                if(response.paymentUrl != undefined && response.paymentUrl != null && response.paymentUrl != '') {
                    window.location.href = response.paymentUrl;
                } else {
                    $('#cart-content').html('<p class="text-sixth-beige">Bestellen gelukt! Je ontvangt binnen enkele minuten een e-mail met het overzicht van je bestelling. ' +
                        'Klik <a class="text-decoration-none text-sixth-yellow" href="/Account">hier</a> om naar je besteloverzicht te gaan.</p>');
                }
            } else {
                alert("Er is iets misgegaan, controleer je bestelling en probeer het opnieuw of neem contact met ons op");
            }
        });
    }

    function processCoupon() {
        $.post('/ShoppingCart/ProcessCoupon', { code: $('#coupon-input').val() }, function(response) {
            if(!response.success) {
                alert('Kortingscode verwerken niet gelukt');
                return;
            }

            $('#discount-amount').text(response.discount);
            $('#discount-applied').removeClass('d-none');
            $('#total-price').text(response.adjustedTotal);
        });
    }
</script>