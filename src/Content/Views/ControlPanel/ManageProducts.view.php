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

        .carousel-image {
            height: 300px;
            object-fit: contain;
            margin-left: auto;
            margin-right: auto;
            display: block;
            width: 100%;
        }
    </style>

    <div id="edit" style="display: none;">
    </div>

    <div id="add">
        <div class="mx-auto" style="width: 100%;">
            <button type="button" id="backToMain" class="btn px-5 btn-primary" style="width: 100%;">
                Back
            </button>
        </div>
        <div class="card mx-auto" style="width: 100%">
            <div class="card-header d-flex justify-content-center">
                <h4>Nieuw product</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="mb-3">
                        <label for="addName">Name</label>
                        <div class="input-group">
                            <input type="text" id="addName" class="form-control" placeholder="Name">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addSubtitle">Subtitle</label>
                        <div class="input-group">
                            <input type="text" id="addSubtitle" class="form-control" placeholder="Subtitle">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addDescription">Description</label>
                        <div class="input-group">
                            <textarea type="text" id="addDescription" class="form-control" placeholder="Description"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select id="status" class="form-select">
                            <option value="null" selected>Select Status</option>
                            <option value="Active">Actief</option>
                            <option value="Inactive">Inactief</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="addStock">Stock</label>
                        <div class="input-group">
                            <input type="number" id="addStock" class="form-control" placeholder="Stock" step="1" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addStock">Demo stock</label>
                        <div class="input-group">
                            <input type="number" id="addDemoStock" class="form-control" placeholder="Demo stock" step="1" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addStock">Prijs</label>
                        <div class="input-group">
                            <input type="number" id="addPrice" class="form-control" placeholder="Prijs" step="0.01" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addStock">Aanbevolen prijs</label>
                        <div class="input-group">
                            <input type="number" id="addRecommendedPrice" class="form-control" placeholder="Aanbevolen prijs" step="0.01" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addSubtitle">Sku</label>
                        <div class="input-group">
                            <input type="text" id="addSku" class="form-control" placeholder="Sku">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addCategory">Category</label>
                        <select id="addCategory" class="form-select category">
                            <option value="null" selected>Select Category</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="addBrand">Brand</label>
                        <select id="addBrand" class="form-select brand" required>
                            <option value="" selected>Select Brand</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="file" id="addThumbnail" style="display: none;" accept="image/*">
                        <button type="button" id="addThumbnailBtn" class="btn px-5 btn-primary w-100">Thumbnail image</button>
                        <div id="thumbnailPreview" hidden></div>
                    </div>

                    <div class="mb-3">
                        <input type="file" id="addMainImage" style="display: none;" accept="image/*">
                        <button type="button" id="addMainImageBtn" class="btn px-5 btn-primary w-100">Main image</button>
                        <div id="mainImagePreview" hidden></div>
                    </div>

                    <script>
                        $(document).on('click', '#addThumbnailBtn', function(event) {
                            $(event.target).siblings('#addThumbnail').click();
                        });

                        $('#addThumbnail').on('change', function() {
                            var file = this.files[0];
                            var reader = new FileReader();

                            $('#thumbnailPreview').removeAttr('hidden');

                            reader.onload = function(e) {
                                var img = $('<img>').attr('src', e.target.result).addClass('d-block carousel-image');
                                $('#thumbnailPreview').empty().append(img);
                            };

                            reader.readAsDataURL(file);
                        });

                        $(document).on('click', '#addMainImageBtn', function(event) {
                            $(event.target).siblings('#addMainImage').click();
                        });

                        $('#addMainImage').on('change', function() {
                            var file = this.files[0];
                            var reader = new FileReader();

                            $('#mainImagePreview').removeAttr('hidden');

                            reader.onload = function(e) {
                                var img = $('<img>').attr('src', e.target.result).addClass('d-block carousel-image');
                                $('#mainImagePreview').empty().append(img);
                            };

                            reader.readAsDataURL(file);
                        });
                    </script>

                    <div class="mb-3">
                        <input type="file" id="addProductImages" style="display: none;" accept="image/*" multiple>
                        <button type="button" class="btn px-5 btn-primary w-100 uploadButton">Product images</button>
                        <div id="productImagesPreview" hidden>
                            <button id="removeItemButton" type="button" class="btn px-5 btn-secondairy">
                                X
                            </button>
                            <div id="productCarousel" style="height: 300px" class="carousel slide">
                                <div class="carousel-inner" style="background-color: black">
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" style="color: black;" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" style="color: black;" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).on('click', '.uploadButton', function(event) {
                            $(event.target).siblings('#addProductImages').click();
                        });

                        var addSelectedFiles = [];

                        $('#addProductImages').on('change', function() {
                            var files = this.files;
                            addSelectedFiles = addSelectedFiles.concat(Array.from(files));
                            var carouselInner = $('#productCarousel .carousel-inner');

                            $('#productImagesPreview').removeAttr('hidden');
                            // Clear the carousel
                            carouselInner.empty();

                            for (var i = 0; i < addSelectedFiles.length; i++) {
                                var file = addSelectedFiles[i];
                                var reader = new FileReader();

                                reader.onload = function(e) {
                                    var img = $('<img>').attr('src', e.target.result).addClass('d-block carousel-image');
                                    var item = $('<div>').addClass('carousel-item').append(img);

                                    // Make the first item active
                                    if (carouselInner.children().length === 0) {
                                        item.addClass('active');
                                    }

                                    carouselInner.append(item);
                                };

                                reader.readAsDataURL(file);
                            }
                            $('#addProductImages').val('');
                        });

                        $('#removeItemButton').on('click', function() {
                            var activeCarouselItem = $('#productCarousel .carousel-item.active');
                            activeCarouselItem.remove();
                            var index = activeCarouselItem.index();


                            addSelectedFiles.splice(index, 1);

                            // If there are no more carousel items, hide the carousel
                            if ($('#productCarousel .carousel-item').length == 0) {
                                $('#productImagesPreview').attr('hidden', 'true');
                            }
                            // If there are still carousel items, make the first one active
                            else {
                                $('#productCarousel .carousel-item').first().addClass('active');
                            }
                        });
                    </script>

                    <div class="mb-3">
                        <label for="addVideo">Youtube video url</label>
                        <div class="input-group">
                            <input type="text" id="addVideo" class="form-control" placeholder="Youtube video url">
                        </div>
                        <div id="videoPreview"></div>

                        <script>
                            $('#addVideo').on('input', function() {
                                var url = $(this).val();
                                var videoId = url.split('v=')[1];
                                var ampersandPosition = videoId.indexOf('&');
                                if (ampersandPosition != -1) {
                                    videoId = videoId.substring(0, ampersandPosition);
                                }

                                $('#videoPreview').html('<iframe width="100%" height="315" src="https://www.youtube.com/embed/' + videoId + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
                            });
                        </script>
                    </div>

                    <button id="submitProduct" type="button" class="btn px-5 btn-primary">
                        Save
                    </button>

                    <script>
                        $('#submitProduct').on('click', function(e) {
                            e.preventDefault();

                            var productData = {
                                name: $('#addName').val(),
                                subtitle: $('#addSubtitle').val(),
                                description: $('#addDescription').val(),
                                status: $('#status').val(),
                                stock: $('#addStock').val(),
                                demoStock: $('#addDemoStock').val(),
                                price: $('#addPrice').val(),
                                recommendedPrice: $('#addRecommendedPrice').val(),
                                sku: $('#addSku').val(),
                                category: $('#addCategory').val(),
                                brand: $('#addBrand').val(),
                                thumbnail: $('#addThumbnail').prop('files')[0],
                                mainImage: $('#addMainImage').prop('files')[0],
                                productImages: addSelectedFiles,
                                video: $('#addVideo').val()
                            };

                            var formData = new FormData();
                            for (var key in productData) {
                                if (key === 'productImages') {
                                    for (var i = 0; i < productData[key].length; i++) {
                                        formData.append(key + '[]', productData[key][i]);
                                    }
                                } else {
                                    formData.append(key, productData[key]);
                                }
                            }

                            $.ajax({
                                url: '/ControlPanel/Products/AddProduct',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    // Handle the response from the server
                                }
                            });
                        });
                    </script>
                </div>
            </div>
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


        <div style="min-height: 460px; overflow-y: hidden; visibility: hidden" id="tablecontainer">
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
</script>