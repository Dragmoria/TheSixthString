<?php
function buildCategoryDropdownElements($selectedFilters, $category, int $index): void {
    $selected = !is_null($selectedFilters->categoryId) && $selectedFilters->categoryId == $category->id ? "selected" : "";
    for($i = 0; $i < $index; $i++) {
        $category->name = "&nbsp;" . $category->name;
    }

    echo '<option ' . $selected . ' value="' . $category->id . '">' . $category->name . '</option>';

    $index += 4;
    foreach($category->children as $childCategory) {
        buildCategoryDropdownElements($selectedFilters, $childCategory, $index);
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-12 mt-4 mb-5 text-center">
            <h1 id="page-title" class="text-sixth-beige">Producten</h1>
        </div>

        <div class="col-12 text-end">
            <label for="sort-dropdown" class="text-sixth-beige">
                Sorteer op:
            </label>
            <select id="sort-dropdown" class="rounded-4" onchange="search()">
                <?php
                foreach (\Lib\Enums\SortType::cases() as $sortType) {
                    $selected = !is_null($selectedFilters->sortOrder) && $selectedFilters->sortOrder == $sortType ? "selected" : "";
                    ?>
                    <option <?= $selected ?> value="<?= $sortType->name ?>"><?= $sortType->toString() ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mt-1 mb-2">
            <hr class="text-sixth-beige"/>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="row">
                <div class="col-12">
                    <label class="text-sixth-beige" for="category-filter"><strong>Categorie</strong></label>
                    <select id="category-filter" class="form-control rounded-4">
                        <option value="">Kies een categorie</option>
                        <?php
                        foreach ($filterData->categories as $category) {
                            buildCategoryDropdownElements($selectedFilters, $category, 0);
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 mt-4">
                    <label class="text-sixth-beige" for="brand-filter"><strong>Merk</strong></label>
                    <select id="brand-filter" class="form-control rounded-4">
                        <option value="">Kies een merk</option>
                        <?php
                        foreach ($filterData->brands as $brand) {
                            $selected = !is_null($selectedFilters->brandId) && $selectedFilters->brandId == $brand->id ? "selected" : "";
                            ?>
                            <option <?= $selected ?> value="<?= $brand->id ?>"><?= $brand->name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12">
                    <div class="row mt-4">
                        <label class="text-sixth-beige"><strong>Prijs</strong>
                        </label>
                        <div class="col">
                            <label for="min-price-filter" class="text-sixth-beige">Minimaal</label>
                            <input id="min-price-filter" type="number" step="1" min="0"
                                   value="<?= $selectedFilters->minPrice ?>" class="form-control">
                        </div>

                        <div class="col">
                            <label for="max-price-filter" class="text-sixth-beige">Maximaal</label>
                            <input id="max-price-filter" type="number" step="1" min="0"
                                   value="<?= $selectedFilters->maxPrice ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-4 mt-3">
                        <input type="checkbox" id="instock-filter" checked>
                        <label for="instock-filter" class="text-sixth-beige">Op voorraad</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-primary sixth-button rounded-4" onclick="search()">Filteren
                    </button>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 mt-2">
            <div class="row">
                <?php
                if (count($products) <= 0) {
                    ?>
                    <p class="text-sixth-beige">Geen producten gevonden</p>
                    <?php
                }

                foreach ($products as $product) {
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <?php
                        echo component(\Http\Controllers\Components\ProductCardComponent::class, (array)$product);
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function search() {
        var selectedCategory = $('#category-filter').val();
        var selectedBrand = $('#brand-filter').val();
        var isInStock = $('#instock-filter').is(":checked");
        var selectedMinPrice = $('#min-price-filter').val();
        var selectedMaxPrice = $('#max-price-filter').val();
        var selectedSortOrder = $('#sort-dropdown').val();

        var queryParts = [];

        if (selectedCategory != '') {
            queryParts.push('category=' + selectedCategory);
        }

        if (selectedBrand != '') {
            queryParts.push('brand=' + selectedBrand);
        }

        queryParts.push('instock=' + isInStock);
        queryParts.push('minprice=' + selectedMinPrice);
        queryParts.push('maxprice=' + selectedMaxPrice);
        queryParts.push('sortorder=' + selectedSortOrder);

        var queryString = '';
        $.each(queryParts, function (index, part) {
            queryString += '&' + part;
        });

        queryString = queryString.substring(1);
        window.location.href = '/Product?' + queryString;
    }
</script>