<?php
$reviewAverage = 0;
?>

<div class="container">
    <div class="row">
        <div class="col-12 mt-3">
            <a href="<?= $previousPage ?>">Terug naar productoverzicht</a>
        </div>
        <div class="col-12 mt-4 mb-5">
            <h1><?= $product->name ?></h1>
        </div>
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12">
                    <img class="rounded img-fluid"
                         src="<?= $product->media->mainImage->url ?? $fallbackMainImage->url ?>"
                         alt="main product image"/>
                </div>
                <div class="col-12 mt-5" id="product-reviews">
                    <h2>Reviews</h2>
                    <?php
                    if (count($product->reviews) <= 0) {
                        ?>
                        <span>Geen reviews beschikbaar</span>
                        <?php
                    } else {
                        $maxReviewAmount = min(count($product->reviews), 10);
                        for ($i = 0; $i < $maxReviewAmount; $i++) {
                            $review = $product->reviews[$i];
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <span>Score: <?= $review->rating ?> / 5</span>
                                    <br/>
                                    <span><strong><?= $review->title ?></strong></span>
                                    <br/>
                                    <span><i>Geschreven op: <?= $review->createdOn ?></i></span>
                                    <p><?= $review->content ?></p>
                                </div>
                            </div>
                            <?php
                        }
                        if (count($product->reviews) > 10) {
                            ?>
                            <i><a>Toon alle reviews</a></i>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12">
                    <h2><?= $product->brand->name ?? "Onbekend merk" ?></h2>
                </div>
                <div clas="col-12">
                    <a href="#product-reviews">Gemiddelde beoordeling: <?= $product->reviewAverage ?> / 5
                        (<?= count($product->reviews) ?> beoordelingen)</a>
                </div>
                <div class="col-12 mt-3">
                    <?= $product->subtitle ?>
                </div>
                <div class="col-12 mt-5">
                    <h1>€<?= number_format($product->unitPrice, 2, ",", ".") ?></h1>
                </div>
                <div class="col-12">
                    <?php
                    if ($product->amountInStock > 0) {
                        ?>
                        <form method="post" action="/ShoppingCart/AddToCart">
                            <div class="row">
                                <div class="col">
                                    <select class="form-select">
                                        <?php
                                        for ($i = 1; $i <= $product->amountInStock; $i++) {
                                            ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary">Toevoegen aan winkelwagen</button>
                                </div>
                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <p>Product niet op voorraad</p>
                        <?php
                    }
                    ?>

                </div>
                <div class="col-12 mt-5">
                    <strong>Productbeschrijving</strong>
                    <p><?= $product->description ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
