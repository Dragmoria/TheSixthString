<div class="d-flex flex-column flex-grow-1">
    <section class="py-5 text-center container">
        <div class="row">
            <div>
                <h1>Beheer categoriën</h1>
            </div>
        </div>
    </section>

    <style>
        .form-control {
            margin-right: 10px;
        }

        .pagination-detail {
            margin-left: 10px;
        }

        #addCategoryButton {
            margin-left: 10px;
        }
    </style>

    <div>
        <div style="min-height: 460px; visibility: hidden" id="tablecontainer">
            <table class="table" id="table" data-toggle="table" data-height="460" data-ajax="fetchCategories" data-search="true" data-side-pagination="server" data-pagination="true" data-filter-control="true" data-reorderable-rows="true">
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="thumbnail" data-formatter="thumbnailFormatter">Thumbnail</th>
                        <th data-field="displayName">Naam</th>
                        <th data-field="description">Beschrijving</th>
                        <th data-field="active">Actief</th>
                        <th data-field="edit" data-formatter="editFormatter"></th>
                    </tr>
                </thead>
            </table>
        </div>

        <button type="button" id="addCategoryButton" class="btn px-5 btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            Categorie toevoegen
        </button>
    </div>

    <div class="modal" tabindex="-1" id="addCategoryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Categorie toevoegen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="was-validated">
                        <div class="mb-3">
                            <label for="addName" class="form-label">Naam:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="addName" placeholder="Naam" aria-label="AddName" aria-describedby="basic-addon1" required>
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="addParentCategory" class="form-label">Parent categorie:</label>
                            <div class="input-group">
                                <select class="form-select" id="addParentCategory" aria-label="AddParentCategory" required>
                                </select>
                                <div class="invalid-feedback">Selecteer een optie.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="addImage" class="form-label">Image:</label>
                            <input type="file" class="form-control" id="addImage" accept="image/*" required>
                            <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100px; height: 100px;">
                            <div class="invalid-feedback">Please select an image.</div>
                        </div>

                        <div>
                            <label for="addDescription">Example textarea</label>
                            <textarea class="form-control" id="addDescription" placeholder="Beschrijving" aria-label="AddDescription" aria-describedby="basic-addon1" rows="3" required></textarea>
                            <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                        </div>

                        <div class="mb-3">
                            <label for="addActive" class="form-label">Actief:</label>
                            <div class="input-group">
                                <select class="form-select" id="addActive" aria-label="AddActive" required>
                                    <option value="active">Actief</option>
                                    <option value="inactive" selected>Inactief</option>
                                </select>
                                <div class="invalid-feedback">Selecteer een optie.</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluit</button>
                    <button id="addSaveButton" type="button" class="btn btn-primary">Opslaan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tablecontainer').css('visibility', 'visible');

        $("#addImage").change(function() {
            readURL(this);
        });
    });

    function fetchCategories(params) {
        // volgens documentatie op https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
        var url = '/ControlPanel/ManageCategories/GetCategoriesTableData';

        $.get(url + '?' + $.param(params.data)).then(function(res) {
            params.success(res)

            var dropdown = $('#addParentCategory'); // Replace with your dropdown's id
            dropdown.empty();

            dropdown.append($('<option></option>').attr('value', 'none').text('None'));

            $.each(res, function(i, category) {
                dropdown.append($('<option></option>').attr('value', category.id).text(category.displayName));
            });
        })
    }

    function thumbnailFormatter(value, row, index) {
        return '<img src="' + value + '" style="width:50px;height:50px;">';
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on('click', '#addSaveButton', function() {
        var formData = new FormData();
        formData.append('_method', "PUT");
        formData.append('addName', $('#addName').val());
        formData.append('addDescription', $('#addDescription').val());
        formData.append('addActive', $('#addActive').val() === "active" ? true : false);
        formData.append('addParentCategory', $('#addParentCategory').val());
        formData.append('addImage', $('#addImage')[0].files[0]);

        $.ajax({
            url: "/ControlPanel/ManageCategories/AddCategory",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                if (response === "Category added") {
                    $('#addCategoryModal').modal('hide');
                    $('#table').bootstrapTable('refresh');
                }
            }
        });
    });
</script>