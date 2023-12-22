<div class="d-flex flex-column flex-grow-1">
    <section class="py-5 text-center container">
        <div class="row">
            <div>
                <h1>Beheer brands</h1>
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

        #addBrandButton {
            margin-left: 10px;
        }
    </style>

    <div>
        <div style="min-height: 460px; visibility: hidden" id="tablecontainer">
            <table class="table" id="table" data-toggle="table" data-height="460" data-ajax="fetchBrands" data-search="true" data-side-pagination="server" data-pagination="true" data-filter-control="true" data-reorderable-rows="true">
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="name" data-sortable="true">Naam</th>
                        <th data-field="description" data-sortable="true">Beschrijving</th>
                        <th data-field="active" data-sortable="true">Actief</th>
                        <th data-field="edit" data-formatter="editFormatter"></th>
                    </tr>
                </thead>
            </table>
        </div>

        <button type="button" id="addBrandButton" class="btn px-5 btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
            Brand toevoegen
        </button>
    </div>

    <div class="modal" tabindex="-1" id="addBrandModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Brand toevoegen</h5>
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

    <div class="modal" tabindex="-1" id="editBrandModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Brand aanpassen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="was-validated">
                        <input type="text" id="editId" hidden>

                        <div class="mb-3">
                            <label for="editName" class="form-label">Naam:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="editName" placeholder="Naam" aria-label="EditName" aria-describedby="basic-addon1" required>
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div>
                            <label for="editDescription">Example textarea</label>
                            <textarea class="form-control" id="editDescription" placeholder="Beschrijving" aria-label="EditDescription" aria-describedby="basic-addon1" rows="3" required></textarea>
                            <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                        </div>

                        <div class="mb-3">
                            <label for="editActive" class="form-label">Actief:</label>
                            <div class="input-group">
                                <select class="form-select" id="editActive" aria-label="EditActive" required>
                                    <option value="active">Actief</option>
                                    <option value="inactive">Inactief</option>
                                </select>
                                <div class="invalid-feedback">Selecteer een optie.</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluit</button>
                    <button id="editSaveButton" type="button" class="btn btn-primary">Opslaan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tablecontainer').css('visibility', 'visible');
    });

    function fetchBrands(params) {
        // volgens documentatie op https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
        var url = '/ControlPanel/ManageBrands/GetBrandsTableData'

        $.get(url + '?' + $.param(params.data)).then(function(res) {
            params.success(res)
        })
    }

    $(document).on('click', '.edit-btn', function() {
        var index = $(this).data('index');
        var row = $('#table').bootstrapTable('getData')[index];

        $('#editId').val(row.id);
        $('#editName').val(row.name);
        $('#editDescription').val(row.description);
        $('#editActive').val(row.active.toLowerCase() === "actief" ? "active" : "inactive");

        $('#editBrandModal').modal('show');
    });

    $(document).on('click', '#editSaveButton', function() {
        var data = {
            _method: "PATCH",
            editId: $('#editId').val(),
            editName: $('#editName').val(),
            editDescription: $('#editDescription').val(),
            editActive: $('#editActive').val() === "active" ? true : false
        }

        $.post("/ControlPanel/ManageBrands/UpdateBrand", data, function(response) {
            if (response === "Brand updated") {
                $('#editBrandModal').modal('hide');
                $('#table').bootstrapTable('refresh');
            }
        });
    });


    $(document).on('click', '#addSaveButton', function() {
        var data = {
            _method: "PUT",
            addName: $('#addName').val(),
            addDescription: $('#addDescription').val(),
            addActive: $('#addActive').val() === "active" ? true : false
        }

        $.post("/ControlPanel/ManageBrands/AddBrand", data, function(response) {
            if (response === "Brand added") {
                $('#addBrandModal').modal('hide');
                $('#table').bootstrapTable('refresh');
            }
        });
    });
</script>