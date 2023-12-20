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