<div class="d-flex flex-column flex-grow-1">
    <section class="py-5 text-center container">
        <div class="row">
            <div>
                <h1>Statistieken</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="visited-products-form">
                    <div class="row">
                        <div class="col-auto">
                            <input type="date" id="start-date" name="min-date" class="form-control bg-beige-color" value="<?= $minDate ?>" />
                        </div>
                        <div class="col-auto">
                            <input type="date" id="end-date" name="max-date" class="form-control bg-beige-color" value="<?= $maxDate ?>" />
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <table>
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Aantal bezoekers</th>
                        <th>Aantal bestellingen</th>
                        <th>Totaal aantal verkocht</th>
                        <th>Conversieratio aantal bestellingen</th>
                        <th>Conversieratio totaal aantal verkocht</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($data as $productSold) {
                        ?>
                        <tr>
                            <td class="text-start p-2"><a href="/Product/<?= $productSold->product->id ?>"><?= $productSold->product->name ?></a></td>
                            <td class="p-2"><?= $productSold->visitors ?></td>
                            <td class="p-2"><?= $productSold->orderAmount ?></td>
                            <td class="p-2"><?= $productSold->totalAmount ?></td>
                            <td class="p-2"><?= number_format($productSold->ratioUniqueOrders, 1, ",", "") ?>%</td>
                            <td class="p-2"><?= number_format($productSold->ratioTotalAmount, 1, ",", "") ?>%</td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>