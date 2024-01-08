<a class="card rounded-5 mb-4 text-decoration-none"
    style="background-color: rgba(255, 255, 255, 0.5); border-style: none; box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.1);"
    href="/Product/<?= $product->id ?>">
    <img class="card-img-top py-3 thumbnail product-thumbnail rounded-5" style="background-color: #ffffff;"
        src="<?= $product->media->thumbnail->url ?? "" ?>" alt="Product image">
    <div class="card-body">
        <div class="row">
            <div class="col-12" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <strong>
                    <?= $product->name ?>
                </strong>
            </div>
            <div class="col-12 mt-2">
                <span style="font-size: 10px; text-decoration: line-through;">Adviesprijs
                    <?= formatPrice($product->recommendedUnitPrice) ?>
                </span>
            </div>
            <div class="col-12">
                <strong>Nu
                    <?= formatPrice($product->unitPrice) ?>
                </strong>
            </div>
            <div class="col-12 mt-2">
                <?php if ($product->amountInStock > 1): ?>
                    <span style="color: #10C900">⬤ Op voorraad</span>
                <?php else: ?>
                    <span style="color: #C90000">✖ Niet op voorraad</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</a>