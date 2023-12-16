<div class="d-flex flex-column flex-grow-1">
    <section class="py-5 text-center container">
        <div class="row">
            <div>
                <h1>Manage vouchers</h1>
                <p>Beheer alle vouchers</p>
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

        #addCouponModal {
            margin-left: 10px;
        }
    </style>

    <div>
        <div style="min-height: 460px; visibility: hidden" id="tablecontainer">
            <table class="table" id="table" data-toggle="table" data-height="460" data-ajax="fetchVouchers" data-search="true" data-side-pagination="server" data-pagination="true" data-filter-control="true" data-reorderable-rows="true">
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="name" data-sortable="true">Naam</th>
                        <th data-field="code" data-sortable="true">Code</th>
                        <th data-field="value" data-sortable="true">Waarde</th>
                        <th data-field="type" data-sortable="true">Type</th>
                        <th data-field="startDate" data-sortable="true">Start datum</th>
                        <th data-field="endDate" data-sortable="true">Eind datum</th>
                        <th data-field="usageAmount" data-sortable="true">Keer gebruikt</th>
                        <th data-field="maxUsageAmount" data-sortable="true">Max te gebruiken</th>
                        <th data-field="active" data-sortable="true">Actief</th>
                        <th data-field="edit" data-formatter="editFormatter"></th>
                    </tr>
                </thead>
            </table>
        </div>

        <button type="button" id="addCouponModal" class="btn px-5 btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Coupon toevoegen
        </button>
    </div>

    <div class="modal" tabindex="-1" id="editCouponModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Coupon aanpassen</h5>
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

                        <div class="mb-3">
                            <label for="editCode" class="form-label">Code:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="editCode" placeholder="Code" aria-label="EditCode" aria-describedby="basic-addon1" required>
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editValue" class="form-label">Waarde:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="editValue" placeholder="Waarde" aria-label="EditValue" aria-describedby="basic-addon1" min="0" step="0.01" required onkeypress="blockKeys(event, '-;+;e;,;.')">
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editType" class="form-label">Type:</label>
                            <div class="input-group">
                                <select class="form-select" id="editType" aria-label="EditType" required>
                                    <option value="amount">Bedrag</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                                <div class="invalid-feedback">Selecteer een optie.</div>
                            </div>
                        </div>

                        <div class="mb-3 date" data-provide="datepicker">
                            <label for="editEndDate" class="form-label">Eind datum:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="editEndDate" placeholder="Eind datum" aria-label="EditEndDate" aria-describedby="basic-addon1">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editMaxAmount" class="form-label">Max te gebruiken:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="editMaxAmount" placeholder="Max te gebruiken" aria-label="EditMaxAmount" aria-describedby="basic-addon1" required min="1" step="1" onkeypress="blockKeys(event, '-;+;e;,;.')">
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editActive" class="form-label">Type:</label>
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
                    <button id="saveButton" type="button" class="btn btn-primary">Opslaan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="was-validated">
                        <div class="mb-3">
                            <label for="newName" class="form-label">Naam:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="newName" placeholder="Naam" aria-label="NewName" aria-describedby="basic-addon1" required>
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newCode" class="form-label">Code:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="newCode" placeholder="Code" aria-label="NewCode" aria-describedby="basic-addon1" required>
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newValue" class="form-label">Waarde:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="newValue" placeholder="Waarde" aria-label="NewValue" aria-describedby="basic-addon1" min="0" step="0.01" required onkeypress="blockKeys(event, '-;+;e;,;.')">
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newType" class="form-label">Type:</label>
                            <div class="input-group">
                                <select class="form-select" id="newType" aria-label="NewType" required>
                                    <option value="amount">Bedrag</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                                <div class="invalid-feedback">Selecteer een optie.</div>
                            </div>
                        </div>

                        <div class="mb-3 date" data-provide="datepicker">
                            <label for="newStartDate" class="form-label">Start datum:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="newStartDate" placeholder="Start datum" aria-label="NewStartDate" aria-describedby="basic-addon1" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div class="mb-3 date" data-provide="datepicker">
                            <label for="newEndDate" class="form-label">Eind datum:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="newEndDate" placeholder="Eind datum" aria-label="NewEndDate" aria-describedby="basic-addon1">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newMaxUsageAmount" class="form-label">Max te gebruiken:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="newMaxUsageAmount" placeholder="Max te gebruiken" aria-label="NewMaxUsageAmount" aria-describedby="basic-addon1" min="1" step="1" required onkeypress="blockKeys(event, '-;+;e;,;.')">
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newActive" class="form-label">Type:</label>
                            <div class="input-group">
                                <select class="form-select" id="newActive" aria-label="NewActive" required>
                                    <option value="active">Actief</option>
                                    <option value="inactive">Inactief</option>
                                </select>
                                <div class="invalid-feedback">Veld mag niet leeg zijn.</div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluit</button>
                    <button id="saveButtonNew" class="btn btn-primary" type="submit">Opslaan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tablecontainer').css('visibility', 'visible');
    });

    function fetchVouchers(params) {
        // volgens documentatie op https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
        var url = '/ControlPanel/ManageCoupons/GetCoupons';

        $.get(url + '?' + $.param(params.data)).then(function(res) {
            params.success(res)
        })
    }

    function editFormatter(value, row, index) {
        return '<button class="btn btn-primary edit-btn" data-index="' + index + '">Edit</button>';
    }



    $(document).on('click', '.edit-btn', function() {
        var index = $(this).data('index');
        var row = $('#table').bootstrapTable('getData')[index];

        $("#editId").val(row.id);
        $("#editName").val(row.name);
        $("#editCode").val(row.code);
        $("#editValue").val(row.value);
        $("#editType").val(row.type.toLowerCase() === "bedrag" ? "amount" : "percentage");
        $("#editEndDate").val(row.endDate);
        $("#editMaxAmount").val(row.maxUsageAmount);
        $("#editActive").val(row.active.toLowerCase() === "actief" ? "active" : "inactive");

        $('#editCouponModal').modal('show');
    });

    $(document).on('click', '#saveButton', function() {
        var data = {
            _method: "PATCH",
            editId: $("#editId").val(),
            editName: $("#editName").val(),
            editCode: $("#editCode").val(),
            editValue: $("#editValue").val(),
            editType: $("#editType").val(),
            editEndDate: $("#editEndDate").val(),
            editMaxUsageAmount: $("#editMaxAmount").val(),
            editActive: $("#editActive").val() === "active" ? true : false
        }

        $.post("/ControlPanel/ManageCoupons/UpdateCoupon", data, function(response) {
            if (response === "Coupon updated") {
                alert("Coupon aangepast");
                $('#editCouponModal').modal('hide');
                $('#table').bootstrapTable('refresh');
            }
        });
    });

    $(document).on('click', '#saveButtonNew', function() {
        var data = {
            _method: "PUT",
            newName: $("#newName").val(),
            newCode: $("#newCode").val(),
            newValue: $("#newValue").val(),
            newType: $("#newType").val(),
            newStartDate: $("#newStartDate").val(),
            newEndDate: $("#newEndDate").val(),
            newMaxUsageAmount: $("#newMaxUsageAmount").val(),
            newActive: $("#newActive").val() === "active" ? true : false
        }

        $.post("/ControlPanel/ManageCoupons/AddNewCoupon", data, function(response) {
            if (response === "Coupon added") {
                alert("Coupon toegevoegd");
                $('#addModal').modal('hide');
                $('#table').bootstrapTable('refresh');

                $("#newName").val('');
                $("#newCode").val('');
                $("#newValue").val('');
                $("#newType").val('');
                $("#newStartDate").val('');
                $("#newEndDate").val('');
                $("#newMaxUsageAmount").val('');
                $("#newActive").val('');
            }
        });
    });
</script>