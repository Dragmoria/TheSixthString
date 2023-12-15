<?php
$selectedCategoryProducts = array();
//TODO:
//als er geen categorieen meer zijn en wel een geselecteerde categorie,
//dan het overzicht met producten tonen voor die geselecteerde categorie -> nieuwe pagina, Products. Dit moet al in de controller gebeuren!
?>
<div class="container">
    <div class="row">
        <div class="col-12 mt-4 mb-5 text-center">
            <h1>Categorieën</h1>
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
                <a class="card rounded-4 mb-4" href="/Category?id=<?= $category->id ?>">
                    <img class="card-img-top rounded-4"
                         src="https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png"
                         alt="Category image">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <p class="card-text h4 text-white"><?= $category->name ?></p>
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
            <?php
            foreach ($selectedCategoryProducts as $product) {
                ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a class="card rounded-4 mb-4" href="/Product?id=<?= $product->id ?>">
                        <img class="card-img-top rounded-4"
                             src="https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png"
                             alt="Category image">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <p class="card-text h4 text-white"><?= $product->name ?></p>
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