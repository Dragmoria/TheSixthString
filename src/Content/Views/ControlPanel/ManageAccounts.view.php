<div class="d-flex flex-grow-1">
    <?php echo component(\Http\Controllers\ControlPanel\SidebarComponent::class); ?>

    <div class="d-flex flex-column flex-grow-1">
        <section class="py-5 text-center container">
            <div class="row">
                <div>
                    <h1>Accounts</h1>
                    <p>Beheer accounts voor staff</p>
                </div>
            </div>
        </section>

        <table id="table" data-toggle="table" data-height="460" data-ajax="fetchUsers" data-search="true" data-side-pagination="server" data-pagination="true">
            <thead>
                <tr>
                    <th data-field="id">Id</th>
                    <th data-field="emailAddress">Email</th>
                    <th data-field="role">Rol</th>
                    <th data-field="firstName">Voornaam</th>
                    <th data-field="insertion">Tussenvoegsel</th>
                    <th data-field="lastName">Achternaam</th>
                    <th data-field="dateOfBirth">Geboortedatum</th>
                    <th data-field="gender">Geslacht</th>
                    <th data-field="active">Actief</th>
                    <th data-field="createdOn">Aangemaakt op</th>
                    <th data-field="edit" data-formatter="editFormatter"></th>
                </tr>
            </thead>
        </table>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Staff account toevoegen
        </button>

        <div class="modal" tabindex="-1" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Staff user toevoegen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newEmail" class="form-label">Email:</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="newEmail" placeholder="Email" aria-label="NewEmail" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newFirstName" class="form-label">Voornaam:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="newFirstName" placeholder="Voornaam" aria-label="NewFirstName" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newInsertion" class="form-label">Tussenvoegsel:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="newInsertion" placeholder="Tussenvoegsel" aria-label="NewInsertion" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newLastName" class="form-label">Achternaam:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="newLastName" placeholder="Achternaam" aria-label="NewLastName" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="mb-3 date" data-provide="datepicker">
                            <label for="newDateOfBirth" class="form-label">Geboortedatum:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="newDateOfBirth" placeholder="Geboortedatum" aria-label="NewDateOfBirth" aria-describedby="basic-addon1">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newGender" class="form-label">Geslacht:</label>
                            <div class="input-group">
                                <select class="form-select" id="newGender" aria-label="NewGender">
                                    <option value="Male">Man</option>
                                    <option value="Female">Vrouw</option>
                                    <option value="Unknown">Anders</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluit</button>
                        <button id="saveButtonNew" type="button" class="btn btn-primary">Opslaan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Staff user aanpassen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="id" hidden>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rol:</label>
                            <div class="input-group">
                                <select class="form-select" id="role" aria-label="Role">
                                    <option value="Staff">Staff</option>
                                    <option value="Analyst">Analyst</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="firstName" class="form-label">Voornaam:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="firstName" placeholder="Voornaam" aria-label="FirstName" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="insertion" class="form-label">Tussenvoegsel:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="insertion" placeholder="Tussenvoegsel" aria-label="Insertion" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lastName" class="form-label">Achternaam:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="lastName" placeholder="Achternaam" aria-label="LastName" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="mb-3 date" data-provide="datepicker">
                            <label for="dateOfBirth" class="form-label">Geboortedatum:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="dateOfBirth" placeholder="Geboortedatum" aria-label="DateOfBirth" aria-describedby="basic-addon1">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Geslacht:</label>
                            <div class="input-group">
                                <select class="form-select" id="gender" aria-label="Gender">
                                    <option value="Male">Man</option>
                                    <option value="Female">Vrouw</option>
                                    <option value="Unknown">Anders</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluit</button>
                        <button id="saveButton" type="button" class="btn btn-primary">Opslaan</button>
                        <button id="resetPasswordButton" type="button" class="btn btn-primary">Reset wachtwoord</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function fetchUsers(params) {
                // volgens documentatie op https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
                var url = '/ControlPanel/Accounts/UsersTableData'

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

                $('#id').val(row.id);
                $('#role').val(row.role);
                $('#firstName').val(row.firstName);
                $('#insertion').val(row.insertion);
                $('#lastName').val(row.lastName);
                $('#dateOfBirth').val(row.dateOfBirth);
                $('#gender').val(row.gender);

                $('#editModal').modal('show');
            });

            $(document).on('click', '#resetPasswordButton', function() {
                var data = {
                    _method: 'PATCH',
                    id: $('#id').val(),
                };

                $.post('/ControlPanel/Accounts/ResetPassword', data).then(function(response) {
                    if (response === 'Password reset') {
                        // Close the modal
                        $('#editModal').modal('hide');

                        $('#table').bootstrapTable('refresh');
                    } else {
                        // Handle error
                        console.log(response);
                    }
                });
            });

            $(document).on('click', '#saveButton', function() {
                var data = {
                    _method: 'PATCH',
                    id: $('#id').val(),
                    role: $('#role').val(),
                    firstName: $('#firstName').val(),
                    insertion: $('#insertion').val(),
                    lastName: $('#lastName').val(),
                    dateOfBirth: $('#dateOfBirth').val(),
                    gender: $('#gender').val()
                };

                $.post('/ControlPanel/Accounts/UpdateUser', data).then(function(response) {
                    if (response === 'User updated') {
                        // Close the modal
                        $('#editModal').modal('hide');

                        $('#table').bootstrapTable('refresh');
                    } else {
                        // Handle error
                        handleInvalidInput(response);
                    }
                });
            });

            const handleInvalidInput = function(data) {
                // Handle error
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                if (Array.isArray(data)) {
                    data.forEach(function(error) {
                        var input = $('#' + error.field);
                        input.addClass('is-invalid');
                        var errorDiv = $('<div>').addClass('invalid-feedback').text(error.message);
                        input.after(errorDiv);
                    });
                } else {
                    console.log(data);
                }
            };



            $(document).on('click', '#saveButtonNew', function() {
                var data = {
                    _method: 'PUT',
                    newEmail: $('#newEmail').val(),
                    newFirstName: $('#newFirstName').val(),
                    newInsertion: $('#newInsertion').val(),
                    newLastName: $('#newLastName').val(),
                    newDateOfBirth: $('#newDateOfBirth').val(),
                    newGender: $('#newGender').val(),
                };

                $.post('/ControlPanel/Accounts/AddUser', data).then(function(response) {
                    if (response === 'User added') {
                        // Close the modal
                        $('#addModal').modal('hide');

                        $('#table').bootstrapTable('refresh');
                    } else {
                        // Handle error
                        handleInvalidInput(response);
                    }
                });
            });
        </script>
    </div>
</div>