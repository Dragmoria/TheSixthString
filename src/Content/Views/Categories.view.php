<?php
$selectedCategoryProducts = array();
?>

<style>
    .thumbnail {
        object-fit: cover;
    }

    .category-thumbnail {
        aspect-ratio: 8 / 5;
    }

    .product-thumbnail {
        aspect-ratio: 4 / 5;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12 mt-4 mb-5 text-center">
            <h1 class="text-sixth-beige">Categorieën</h1>
        </div>
    </div>
    <div class="row">
        <?php
        foreach ($categories as $category) {
            if ($category->isSelectedCategory) {
                $selectedCategoryProducts = $category->products;
                continue;
            }
            ?>
            <div class="col-6 col-md-4">
                <a class="card bg-sixth-beige rounded-4 mb-4 text-decoration-none" href="/Category?id=<?= $category->id ?>">
                    <img class="card-img-top rounded-4 thumbnail category-thumbnail"
                         src="<?= $category->media->thumbnail->url ?? "" ?>"
                         alt="Category image">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <p class="card-text h4 text-sixth-brown"><?= $category->name ?></p>
                    </div>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    if (count($selectedCategoryProducts) > 0) {
        ?>
        <div class="row">
            <div class="col-10 offset-1 mt-4 mb-5">
                <hr class="text-sixth-beige"/>
            </div>
        </div>
        <div class="row">
            <?php
            foreach ($selectedCategoryProducts as $product) {
                ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a class="card bg-sixth-beige rounded-4 mb-4 text-decoration-none" href="/Product/<?= $product->id ?>">
                        <img class="card-img-top thumbnail product-thumbnail rounded-4"
                             src="<?= $product->media->thumbnail->url ?>"
                             alt="Category image">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <strong><?= $product->name ?></strong>
                                </div>
                                <div class="col-12">
                                    <span>Adviesprijs <?= formatPrice($product->recommendedUnitPrice) ?></span>
                                </div>
                                <div class="col-12">
                                    <strong>Nu <?= formatPrice($product->unitPrice) ?></strong>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>