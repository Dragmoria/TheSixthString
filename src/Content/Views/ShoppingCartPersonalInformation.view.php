<?php

use Lib\Enums\AddressType;
use Lib\Enums\Country;

?>
<div class="container">
    <div class="row" style="padding-top:5rem; min-height:100vh;">
        <div class="col-12 mt-3 mb-3" id="cart-content">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card rounded-4 p-2 bg-sixth-black text-sixth-beige">
                        <h1 class="text-sixth-beige">Persoonlijke gegevens</h1>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <span><strong>Tav: <?= $fullName ?></strong></span>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="row">

                                        <?php
                                        foreach ($addresses as $address) {
                                            ?>
                                            <div class="col-12 col-md-6">
                                                <h6><strong><?= AddressType::from($address->type)->toString() ?></strong></h6>
                                                <table>
                                                    <tbody>
                                                    <tr>
                                                        <td class="p-1">Straat</td>
                                                        <td class="p-1"><?= $address->street ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Huisnummer (+ toevoeging)</td>
                                                        <td class="p-1"><?= $address->housenumber . (!is_null($address->housenumberExtension) ? " " . $address->housenumberExtension : "") ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Postcode</td>
                                                        <td class="p-1"><?= $address->zipCode ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Plaats</td>
                                                        <td class="p-1"><?= $address->city ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Land</td>
                                                        <td class="p-1"><?= Country::from($address->country)->toStringTranslate() ?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                </div>
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
    $(document).ready(function () {
        $('#cart-button').attr('href', '/ShoppingCart/Payment');
    });
</script>