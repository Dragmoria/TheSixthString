<?php
$reviewAverage = 0;
?>

<style>
    .product-thumbnail {
        width: 75px;
        height: 100px;
        object-fit: cover;
        aspect-ratio: 4 / 5;
    }

    #main-product-image {
        object-fit: cover;
        aspect-ratio: 4 / 5;
    }

    #thumbnail-slider {
        margin-left: calc(var(--bs-gutter-x) * .5);
    }

    #product-video-thumbnail {
        fill: red;
    }
</style>

<div class="container text-sixth-beige">
    <div class="row">
        <div class="col-12 mt-3">
            <a class="text-sixth-beige" href="#" onclick="history.go(-1);">Terug naar productoverzicht</a>
        </div>
        <div class="col-12 mt-4 mb-5">
            <h1><?= $product->name ?></h1>
        </div>
        <div class="col-12 col-md-5">
            <div class="row">
                <div id="media-container" class="col-12" data-type-shown="image">
                    <img id="main-product-image" class="rounded-4 img-fluid"
                         src="<?= $product->media->mainImage->url ?>"
                         alt="main product image"/>
                    <iframe id="product-video" class="d-none w-100 rounded" width="560" height="315" src="<?= $product->media->video->url ?>"
                            title="<?= $product->media->video->title ?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="col-9">
                    <div class="row">
                        <div id="thumbnail-slider" class="col-12 mt-4 text-nowrap overflow-x-scroll ps-0 pe-0">
                            <?php
                            for($i = 0; $i < count($product->media->secondaryImages); $i++) {
                                $secondaryImage = $product->media->secondaryImages[$i];
                                ?>
                                <img class="product-thumbnail cursor-pointer rounded-4 <?= $i == 0 ? "mb-3" : "" ?>" data-type="image" src="<?= $secondaryImage->url ?>"
                                     alt="<?= $secondaryImage->title ?>" onclick="selectImage(this)"/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-3 d-flex">
                    <svg id="product-video-thumbnail" class="cursor-pointer rounded-4 m-auto"
                         onclick="toggleMediaVisibility(this)" data-type="video"
                         xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 384 512">
                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                        <path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7">
            <div class="row">
                <div class="col-12">
                    <h2><?= $product->brand->name ?? "Onbekend merk" ?></h2>
                </div>
                <div class="col-12">
                    <a class="text-sixth-beige" href="#product-reviews">Gemiddelde beoordeling: <?= $product->reviewAverage ?> / 5
                        (<?= count($product->reviews) ?> beoordelingen)</a>
                </div>
                <div class="col-12 mt-3">
                    <?= $product->subtitle ?>
                </div>
                <Div class="col-12 mt-2">
                    <small>Artikelcode: <?= $product->sku ?></small>
                    <div class="col-12 mt-5">
                        <span>Adviesprijs <?= formatPrice($product->recommendedUnitPrice) ?></span>
                        <h1>Nu <?= formatPrice($product->unitPrice) ?></h1>
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
                                        <button class="btn btn-primary sixth-button rounded-4">Toevoegen aan winkelwagen</button>
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
    <div class="row mt-5">
        <div class="col-12 col-md-6" id="product-reviews">
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
        <div class="col-12 col-md-6">
            <h2>Product uitproberen</h2>
            <p>...</p>
        </div>

        <script>
            function selectImage(element) {
                toggleMediaVisibility(element);

                $('#main-product-image').attr('src', element.src);
            }

            function toggleMediaVisibility(element) {
                $('.product-thumbnail').removeClass('mb-3');
                $('#product-video-thumbnail').removeClass('mb-3');
                $(element).addClass('mb-3');

                if($(element).data('type') != $('#media-container').data('type-shown')) {
                    $('#main-product-image').toggleClass('d-none');
                    $('#product-video').toggleClass('d-none');
                }

                $('#media-container').data('type-shown', $(element).data('type'));
            }
        </script>