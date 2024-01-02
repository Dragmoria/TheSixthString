<div class="d-flex flex-column flex-grow-1">

    <style>
        .form-control {
            margin-right: 10px;
        }

        .pagination-detail {
            margin-left: 10px;
        }

        #addProductButton {
            margin-left: 10px;
        }
    </style>

    <div id="edit" style="display: none;">
    </div>

    <div id="add">
        <div>
            <button type="button" id="backToMain" class="btn px-5 btn-primary">
                Back
            </button>
        </div>
        <div class="card mx-auto" style="width: 80%">
            <div class="card-header d-flex justify-content-center">
                <h4>Nieuw product</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="">
                        <label for="addName">Name</label>
                        <div class="input-group">
                            <input type="text" id="addName" class="form-control" placeholder="Name">
                        </div>
                    </div>

                    <div class="">
                        <label for="addSubtitle">Subtitle</label>
                        <div class="input-group">
                            <input type="text" id="addSubtitle" class="form-control" placeholder="Subtitle">
                        </div>
                    </div>

                    <div class="">
                        <label for="addDescription">Description</label>
                        <div class="input-group">
                            <textarea type="text" id="addDescription" class="form-control" placeholder="Description"></textarea>
                        </div>
                    </div>

                    <div class="">
                        <label for="status">Status</label>
                        <select id="status" class="form-select">
                            <option value="null" selected>Select Status</option>
                            <option value="Active">Actief</option>
                            <option value="Inactive">Inactief</option>
                        </select>
                    </div>

                    <div class="">
                        <label for="addStock">Stock</label>
                        <div class="input-group">
                            <input type="number" id="addStock" class="form-control" placeholder="Stock" step="1" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="">
                        <label for="addStock">Demo stock</label>
                        <div class="input-group">
                            <input type="number" id="addDemoStock" class="form-control" placeholder="Demo stock" step="1" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="">
                        <label for="addStock">Prijs</label>
                        <div class="input-group">
                            <input type="number" id="addPrice" class="form-control" placeholder="Prijs" step="0.01" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="">
                        <label for="addStock">Aanbevolen prijs</label>
                        <div class="input-group">
                            <input type="number" id="addRecommendedPrice" class="form-control" placeholder="Aanbevolen prijs" step="0.01" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="">
                        <label for="addSubtitle">Sku</label>
                        <div class="input-group">
                            <input type="text" id="addSku" class="form-control" placeholder="Sku">
                        </div>
                    </div>

                    <div class="">
                        <label for="addCategory">Category</label>
                        <select id="addCategory" class="form-select category">
                            <option value="null" selected>Select Category</option>
                        </select>
                    </div>

                    <div class="">
                        <label for="addBrand">Brand</label>
                        <select id="addBrand" class="form-select brand" required>
                            <option value="" selected>Select Brand</option>
                        </select>
                    </div>

                    <div>
                        <input type="file" id="addThumbnail" style="display: none;" accept="image/*">
                        <button type="button" id="uploadButton" class="btn px-5 btn-primary w-100">Thumbnail image</button>
                        <div id="thumbnailPreview"></div>
                    </div>

                    <div>
                        <input type="file" id="addMainImage" style="display: none;" accept="image/*">
                        <button type="button" id="uploadButton" class="btn px-5 btn-primary w-100">Main image</button>
                        <div id="mainImagePreview"></div>
                    </div>

                    <div>
                        <input type="file" id="addProductImages" style="display: none;" accept="image/*" multiple>
                        <button type="button" id="uploadButton" class="btn px-5 btn-primary w-100">Product images</button>
                        <div id="productImagesPreview" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" style="height: 100px"></div>
                            <a class="carousel-control-prev" href="#productImagesPreview" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#productImagesPreview" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                    <div class="">
                        <label for="addVideo">Youtube video url</label>
                        <div class="input-group">
                            <input type="text" id="addVideo" class="form-control" placeholder="Youtube video url">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column">

        </div>
    </div>

    <div id="main" style="display: none;">
        <div class="card mb-3">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="search">Search</label>
                            <div class="input-group">
                                <input type="text" id="search" class="form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.previousElementSibling.value=''">Clear</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="category">Category</label>
                            <select id="category" class="form-select category">
                                <option value="null" selected>Select Category</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="brand">Brand</label>
                            <select id="brand" class="form-select brand">
                                <option value="null" selected>Select Brand</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status">Status</label>
                            <select id="status" class="form-select">
                                <option value="null" selected>Select Status</option>
                                <option value="Active">Actief</option>
                                <option value="Inactive">Inactief</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="sku">SKU</label>
                            <div class="input-group">
                                <input type="text" id="sku" class="form-control" placeholder="SKU">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.previousElementSibling.value=''">Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <button id="searchButton" class="btn btn-primary" style="width: 150px">Search</button>
                    </div>
                </div>
            </div>
        </div>


        <div style="min-height: 460px; visibility: hidden" id="tablecontainer">
            <table class="table" id="table" data-toggle="table" data-height="460" data-ajax="fetchProducts" data-side-pagination="server" data-pagination="true">
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="thumbnail" data-formatter="thumbnailFormatter">Thumbnail</th>
                        <th data-field="name">Product</th>
                        <th data-field="amountInStock">Stock</th>
                        <th data-field="unitPrice">Prijs</th>
                        <th data-field="active">Actief</th>
                        <th data-field="edit" data-formatter="editFormatter"></th>
                    </tr>
                </thead>
            </table>
        </div>

        <button type="button" id="addProductButton" class="btn px-5 btn-primary">
            Product toevoegen
        </button>
    </div>
</div>

<script>
    function preventKeys(e) {
        if (e.key === 'e' || e.key === '-' || e.key === '+' || e.key === 'E' || e.key === '.') {
            e.preventDefault();
            return;
        }

        var step = parseFloat(e.target.getAttribute('step'));

        if (step === 1) {
            if (e.key === ',') {
                e.preventDefault();
                return;
            }
        }
        var old = e.target.value;

        e.target.addEventListener("keyup", function(event) {
            e.target.removeEventListener("keyup", arguments.callee);

            if (event.key === "Backspace") {
                return;
            }

            var decimalPlaces = (step.toString().split('.')[1] || []).length;

            var decimalPart = e.target.value.split('.')[1];

            if (decimalPart !== undefined && decimalPart.length > decimalPlaces) {
                e.target.value = old;
            }
        });
    }


    $(document).ready(function() {
        $('#tablecontainer').css('visibility', 'visible');

        $('#searchButton').click(function() {
            $('#table').bootstrapTable('refresh');
        });

        // $('#add').hide();
        // $('#edit').hide();

        LoadBrands();
        LoadCategories();
    });

    $(document).on('click', '.edit-btn', function() {
        var index = $(this).data('index');
        var row = $('#table').bootstrapTable('getData')[index];

        $('#main').hide();
        $('#edit').show();
    });

    $(document).on('click', '#addProductButton', function() {
        $('#main').hide();
        $('#add').show();
    });

    $(document).on('click', '#backToMain', function() {
        $('#main').show();
        $('#add').hide();
        $('#edit').hide();
    });


    function thumbnailFormatter(value, row, index) {
        if (!value) {
            return 'none';
        } else {
            return '<img src="' + value + '" style="width:50px;height:50px;">';
        }
    }

    function fetchProducts(params) {
        // volgens documentatie op https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
        var url = '/ControlPanel/ManageProducts/GetProductsTableData';

        params.data.search = $('#search').val();
        params.data.categoryId = $('#category').val();
        params.data.brandId = $('#brand').val();
        params.data.status = $('#status').val();
        params.data.sku = $('#sku').val();

        $.get(url + '?' + $.param(params.data)).then(function(res) {
            params.success(res)
        })
    }

    function LoadBrands() {
        $.ajax({
            url: '/ControlPanel/ManageProducts/GetBrands',
            type: 'GET',
            success: function(data) {
                var brands = data;
                var brandSelects = $('.brand');

                $.each(brandSelects, function(index, select) {
                    var brandSelect = $(select); // Convert the DOM element to a jQuery object

                    $.each(brands, function(index, brand) {
                        brandSelect.append('<option value="' + brand.id + '">' + brand.name + '</option>');
                    });
                });
            }
        });
    }

    function LoadCategories() {
        $.ajax({
            url: '/ControlPanel/ManageProducts/GetCategories',
            type: 'GET',
            success: function(data) {
                var categories = data;
                var categorySelects = $('.category');

                $.each(categorySelects, function(index, select) {
                    var categorySelect = $(select); // Convert the DOM element to a jQuery object

                    $.each(categories, function(index, category) {
                        categorySelect.append('<option value="' + category.id + '">' + category.name + '</option>');
                    });
                });
            }
        });
    }

    $('#uploadButton').on('click', function() {
        $('#addProductImages').click();
    });

    $('#addProductImages').on('change', function() {
        var files = this.files;
        var carouselInner = $('#productImagesPreview .carousel-inner');

        // Clear the carousel
        carouselInner.empty();

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = $('<img>').attr('src', e.target.result).addClass('d-block w-100');
                var item = $('<div>').addClass('carousel-item').append(img);

                // Make the first item active
                if (carouselInner.children().length === 0) {
                    item.addClass('active');
                }

                carouselInner.append(item);
            };

            reader.readAsDataURL(file);
        }
    });
</script>