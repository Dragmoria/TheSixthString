<div class="d-flex flex-column flex-grow-1">

    <style>
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

    <div id="add" style="display: none;">
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
                        <label for="addStatus">Status</label>
                        <select id="addStatus" class="form-select">
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
                        <label for="addDemoStock">Demo stock</label>
                        <div class="input-group">
                            <input type="number" id="addDemoStock" class="form-control" placeholder="Demo stock" step="1" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addPrice">Prijs</label>
                        <div class="input-group">
                            <input type="number" id="addPrice" class="form-control" placeholder="Prijs" step="0.01" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addRecommendedPrice">Aanbevolen prijs</label>
                        <div class="input-group">
                            <input type="number" id="addRecommendedPrice" class="form-control" placeholder="Aanbevolen prijs" step="0.01" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="addSku">Sku</label>
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
                        <div id="addThumbnailPreview" hidden></div>
                    </div>

                    <div class="mb-3">
                        <input type="file" id="addMainImage" style="display: none;" accept="image/*">
                        <button type="button" id="addMainImageBtn" class="btn px-5 btn-primary w-100">Main image</button>
                        <div id="addMainImagePreview" hidden></div>
                    </div>

                    <script>
                        $(document).on('click', '#addThumbnailBtn', function(event) {
                            $(event.target).siblings('#addThumbnail').click();
                        });

                        $('#addThumbnail').on('change', function() {
                            var file = this.files[0];
                            var reader = new FileReader();

                            $('#addThumbnailPreview').removeAttr('hidden');

                            reader.onload = function(e) {
                                var img = $('<img>').attr('src', e.target.result).addClass('d-block carousel-image');
                                $('#addThumbnailPreview').empty().append(img);
                            };

                            reader.readAsDataURL(file);
                        });

                        $(document).on('click', '#addMainImageBtn', function(event) {
                            $(event.target).siblings('#addMainImage').click();
                        });

                        $('#addMainImage').on('change', function() {
                            var file = this.files[0];
                            var reader = new FileReader();

                            $('#addMainImagePreview').removeAttr('hidden');

                            reader.onload = function(e) {
                                var img = $('<img>').attr('src', e.target.result).addClass('d-block carousel-image');
                                $('#addMainImagePreview').empty().append(img);
                            };

                            reader.readAsDataURL(file);
                        });
                    </script>

                    <div class="mb-3">
                        <input type="file" id="addProductImages" style="display: none;" accept="image/*" multiple>
                        <button type="button" class="btn px-5 btn-primary w-100 addUploadButton">Product images</button>
                        <div id="addProductImagesPreview" hidden>
                            <button id="addRemoveItemButton" type="button" class="btn px-5 btn-secondairy">
                                X
                            </button>
                            <div id="addProductCarousel" style="height: 300px" class="carousel slide">
                                <div class="carousel-inner" style="background-color: black">
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#addProductCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" style="color: black;" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#addProductCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" style="color: black;" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).on('click', '.addUploadButton', function(event) {
                            $(event.target).siblings('#addProductImages').click();
                        });

                        var addSelectedFiles = [];

                        $('#addProductImages').on('change', function() {
                            var files = this.files;
                            addSelectedFiles = addSelectedFiles.concat(Array.from(files));
                            var carouselInner = $('#addProductCarousel .carousel-inner');

                            $('#addProductImagesPreview').removeAttr('hidden');
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

                        $('#addRemoveItemButton').on('click', function() {
                            var activeCarouselItem = $('#addProductCarousel .carousel-item.active');
                            activeCarouselItem.remove();
                            var index = activeCarouselItem.index();


                            addSelectedFiles.splice(index, 1);

                            // If there are no more carousel items, hide the carousel
                            if ($('#addProductCarousel .carousel-item').length == 0) {
                                $('#addProductImagesPreview').attr('hidden', 'true');
                            }
                            // If there are still carousel items, make the first one active
                            else {
                                $('#addProductCarousel .carousel-item').first().addClass('active');
                            }
                        });
                    </script>

                    <div class="mb-3">
                        <label for="addVideo">Youtube video url</label>
                        <div class="input-group">
                            <input type="text" id="addVideo" class="form-control" placeholder="Youtube video url">
                        </div>
                        <div id="addVideoPreview"></div>

                        <script>
                            $('#addVideo').on('input', function() {
                                var url = $(this).val();
                                var videoId = url.split('v=')[1];
                                var ampersandPosition = videoId.indexOf('&');
                                if (ampersandPosition != -1) {
                                    videoId = videoId.substring(0, ampersandPosition);
                                }

                                $('#addVideoPreview').html('<iframe width="100%" height="315" src="https://www.youtube.com/embed/' + videoId + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
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
                                status: $('#addStatus').val(),
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
                                if (key === 'addProductImages') {
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

    <div id="main">
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



    <div id="edit" style="display: none;">
        <div class="mx-auto" style="width: 100%;">
            <button type="button" id="backToMain" class="btn px-5 btn-primary" style="width: 100%;">
                Back
            </button>
        </div>
        <div class="card mx-auto" style="width: 100%">
            <div class="card-header d-flex justify-content-center">
                <h4>Edit product</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="mb-3">
                        <label for="editName">Name</label>
                        <div class="input-group">
                            <input type="text" id="editName" class="form-control" placeholder="Name">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editSubtitle">Subtitle</label>
                        <div class="input-group">
                            <input type="text" id="editSubtitle" class="form-control" placeholder="Subtitle">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editDescription">Description</label>
                        <div class="input-group">
                            <textarea type="text" id="editDescription" class="form-control" placeholder="Description"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editStatus">Status</label>
                        <select id="editStatus" class="form-select">
                            <option value="null" selected>Select Status</option>
                            <option value="Active">Actief</option>
                            <option value="Inactive">Inactief</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editStock">Stock</label>
                        <div class="input-group">
                            <input type="number" id="editStock" class="form-control" placeholder="Stock" step="1" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editDemoStock">Demo stock</label>
                        <div class="input-group">
                            <input type="number" id="editDemoStock" class="form-control" placeholder="Demo stock" step="1" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editPrice">Prijs</label>
                        <div class="input-group">
                            <input type="number" id="editPrice" class="form-control" placeholder="Prijs" step="0.01" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editRecommendedPrice">Aanbevolen prijs</label>
                        <div class="input-group">
                            <input type="number" id="editRecommendedPrice" class="form-control" placeholder="Aanbevolen prijs" step="0.01" onkeydown="preventKeys(event)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editSku">Sku</label>
                        <div class="input-group">
                            <input type="text" id="editSku" class="form-control" placeholder="Sku">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editCategory">Category</label>
                        <select id="editCategory" class="form-select category">
                            <option value="null" selected>Select Category</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editBrand">Brand</label>
                        <select id="editBrand" class="form-select brand" required>
                            <option value="" selected>Select Brand</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="file" id="editThumbnail" style="display: none;" accept="image/*">
                        <button type="button" id="editThumbnailBtn" class="btn px-5 btn-primary w-100">Thumbnail image</button>
                        <div id="editThumbnailPreview" hidden></div>
                    </div>

                    <div class="mb-3">
                        <input type="file" id="editMainImage" style="display: none;" accept="image/*">
                        <button type="button" id="editMainImageBtn" class="btn px-5 btn-primary w-100">Main image</button>
                        <div id="editMainImagePreview" hidden></div>
                    </div>

                    <script>
                        $(document).on('click', '#editThumbnailBtn', function(event) {
                            $(event.target).siblings('#editThumbnail').click();
                        });

                        $('#editThumbnail').on('change', function() {
                            var file = this.files[0];
                            var reader = new FileReader();

                            $('#editThumbnailPreview').removeAttr('hidden');

                            reader.onload = function(e) {
                                var img = $('<img>').attr('src', e.target.result).addClass('d-block carousel-image');
                                $('#editThumbnailPreview').empty().append(img);
                            };

                            reader.readAsDataURL(file);
                        });

                        $(document).on('click', '#editMainImageBtn', function(event) {
                            $(event.target).siblings('#editMainImage').click();
                        });

                        $('#editMainImage').on('change', function() {
                            var file = this.files[0];
                            var reader = new FileReader();

                            $('#editMainImagePreview').removeAttr('hidden');

                            reader.onload = function(e) {
                                var img = $('<img>').attr('src', e.target.result).addClass('d-block carousel-image');
                                $('#editMainImagePreview').empty().append(img);
                            };

                            reader.readAsDataURL(file);
                        });
                    </script>

                    <div class="mb-3">
                        <input type="file" id="editProductImages" style="display: none;" accept="image/*" multiple>
                        <button type="button" class="btn px-5 btn-primary w-100 editUploadButton">Product images</button>
                        <div id="editProductImagesPreview" hidden>
                            <button id="editRemoveItemButton" type="button" class="btn px-5 btn-secondairy">
                                X
                            </button>
                            <div id="editProductCarousel" style="height: 300px" class="carousel slide">
                                <div class="carousel-inner" style="background-color: black">
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#editProductCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" style="color: black;" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#editProductCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" style="color: black;" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).on('click', '.editUploadButton', function(event) {
                            $(event.target).siblings('#editProductImages').click();
                        });

                        var editSelectedFiles = [];

                        function makeCarouselImage(src, carouselInner) {
                            var img = $('<img>').attr('src', src).addClass('d-block carousel-image');
                            var item = $('<div>').addClass('carousel-item').append(img);

                            // Make the first item active
                            if (carouselInner.children().length === 0) {
                                item.addClass('active');
                            }

                            carouselInner.append(item);

                            return item;
                        }

                        $('#editProductImages').on('change', function() {
                            var files = this.files;
                            editSelectedFiles = editSelectedFiles.concat(Array.from(files));
                            var carouselInner = $('#editProductCarousel .carousel-inner');

                            $('#editProductImagesPreview').removeAttr('hidden');
                            // Clear the carousel
                            carouselInner.empty();

                            for (var i = 0; i < editSelectedFiles.length; i++) {
                                if (editSelectedFiles[i].old) {
                                    makeCarouselImage(editSelectedFiles[i].url, carouselInner);
                                } else {
                                    var file = editSelectedFiles[i];
                                    var reader = new FileReader();

                                    reader.onload = function(e) {
                                        makeCarouselImage(e.target.result, carouselInner);
                                    };

                                    reader.readAsDataURL(file);
                                }
                            }
                            $('#editProductImages').val('');
                        });

                        $('#editRemoveItemButton').on('click', function() {
                            var activeCarouselItem = $('#editProductCarousel .carousel-item.active');
                            activeCarouselItem.remove();
                            var index = activeCarouselItem.index();


                            editSelectedFiles.splice(index, 1);

                            // If there are no more carousel items, hide the carousel
                            if ($('#editProductCarousel .carousel-item').length == 0) {
                                $('#editProductImagesPreview').attr('hidden', 'true');
                            }
                            // If there are still carousel items, make the first one active
                            else {
                                $('#editProductCarousel .carousel-item').first().addClass('active');
                            }
                        });
                    </script>

                    <div class="mb-3">
                        <label for="editVideo">Youtube video url</label>
                        <div class="input-group">
                            <input type="text" id="editVideo" class="form-control" placeholder="Youtube video url">
                        </div>
                        <div id="editVideoPreview"></div>

                        <script>
                            $('#editVideo').on('input', function() {
                                makeVideoPreview($(this).val(), $('#editVideoPreview'));
                            });

                            function makeVideoPreview(url, target) {
                                var videoId = url.split('v=')[1];
                                var ampersandPosition = videoId.indexOf('&');
                                if (ampersandPosition != -1) {
                                    videoId = videoId.substring(0, ampersandPosition);
                                }

                                target.html('<iframe width="100%" height="315" src="https://www.youtube.com/embed/' + videoId + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
                            }
                        </script>
                    </div>

                    <button id="editSubmitProduct" type="button" class="btn px-5 btn-primary">
                        Save
                    </button>

                    <script>
                        $('#editSubmitProduct').on('click', function(e) {
                            e.preventDefault();

                            var productData = {

                            };

                            var formData = new FormData();
                            for (var key in productData) {
                                if (key === 'editProductImages') {
                                    for (var i = 0; i < productData[key].length; i++) {
                                        formData.append(key + '[]', productData[key][i]);
                                    }
                                } else {
                                    formData.append(key, productData[key]);
                                }
                            }

                            $.ajax({
                                url: '/ControlPanel/Products/EditProduct',
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
</div>

<script>
    $(document).on('click', '.edit-btn', function() {
        var index = $(this).data('index');
        var row = $('#table').bootstrapTable('getData')[index];

        var carouselInner = $('#editProductCarousel .carousel-inner');
        editSelectedFiles = [];

        row.media.secondaryImages.forEach(element => {
            editSelectedFiles.push({
                old: true,
                url: element.url
            });
        });

        for (var i = 0; i < editSelectedFiles.length; i++) {
            makeCarouselImage(editSelectedFiles[i].url, carouselInner);
        }
        $('#editProductImagesPreview').removeAttr('hidden');

        $('#editThumbnailPreview').removeAttr('hidden');

        $('#editThumbnailPreview').empty().append(
            $('<img>').attr('src', row.media.thumbnail.url).addClass('d-block carousel-image')
        );

        $('#editMainImagePreview').removeAttr('hidden');

        $('#editMainImagePreview').empty().append(
            $('<img>').attr('src', row.media.mainImage.url).addClass('d-block carousel-image')
        );

        try {
            makeVideoPreview(row.media.video.url, $('#editVideoPreview'));
        } catch (e) {
            console.log(e);
        }

        $('#editName').val(row.name);
        $('#editSubtitle').val(row.subtitle);
        $('#editDescription').val(row.description);
        $('#editStatus').val(row.active ? "Active" : "Inactive");
        $('#editStock').val(row.amountInStock);
        $('#editDemoStock').val(row.amountInDemoStock);
        $('#editPrice').val(row.unitPrice);
        $('#editRecommendedPrice').val(row.recommendedPrice);
        $('#editSku').val(row.sku);
        $('#editCategory').val(row.category.id);
        $('#editBrand').val(row.brand.id);
        $('#editVideo').val(row.media.video.url);



        $('#main').hide();
        $('#edit').show();
    });

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

        $('#add').hide();
        $('#edit').hide();

        LoadBrands();
        LoadCategories();
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