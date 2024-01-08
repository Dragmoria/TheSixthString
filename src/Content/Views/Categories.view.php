<?php
$selectedCategoryProducts = array();
$pageTitle = "Categorieën";

foreach ($categories as $category) {
    if ($category->isSelectedCategory) {
        $selectedCategoryProducts = $category->products;
        $pageTitle = $category->name;
    }
}
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

<div class="container" style="min-height: 100vh;">
    <div class="row" style="margin-top: 5rem;">
        <div class="col-12 mt-4 mb-5 text-center">
            <h1 id="page-title" class="text-sixth-beige"><?= $pageTitle ?></h1>
        </div>
    </div>
    <div class="row">
        <?php
        foreach ($categories as $category) {
            if ($category->isSelectedCategory) {
                continue;
            }
            ?>
            <div class="col-6 col-md-4">
                <a class="card bg-sixth-beige rounded-4 mb-4 text-decoration-none"
                   href="/Category/<?= $category->id ?>">
                    <img class="card-img-top rounded-4 thumbnail category-thumbnail"
                         src="<?= $category->media->thumbnail->url ?? "" ?>"
                         alt="Category image">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <p class="card-text h4 text-sixth-beige text-center" style="text-shadow: 0px 0px 20px rgba(0,0,0,1);"><strong><?= $category->name ?></strong></p>
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
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <?php
                    echo component(\Http\Controllers\Components\ProductCardComponent::class, (array)$product);
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>