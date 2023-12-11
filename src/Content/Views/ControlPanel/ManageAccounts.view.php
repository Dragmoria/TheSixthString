<div class="d-flex flex-grow-1">
    <?php echo component(\Http\Controllers\ControlPanel\SidebarComponent::class); ?>

    <div class="d-flex flex-column flex-grow-1">
        <section class="py-5 text-center container">
            <div class="row">
                <div>
                    <h1>Accounts</h1>
                    <p>Manage accounts voor staff</p>
                </div>
            </div>
        </section>
        <table class="table" data-toggle="table" data-pagination="true" data-search="true">
            <thead>
                <tr>
                    <th scope="col">Email adres</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Naam</th>
                    <th scope="col">Geboortedatum</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Actief</th>
                    <th scope="col">Aangemaakt op</th>
                </tr>
            </thead>

            https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
            check it out might be nice
            <tbody>
                <?php
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . $user->emailAddress . "</td>";
                    echo "<td>" . $user->role->toString() . "</td>";
                    echo "<td>" . $user->firstName . " " . $user->insertion . " " . $user->lastName . "</td>";
                    echo "<td>" . $user->dateOfBirth->format('d-m-Y') . "</td>";
                    echo "<td>" . $user->gender->toString() . "</td>";
                    echo "<td>" . $user->active . "</td>";
                    echo "<td>" . $user->createdOn->format('d-m-Y') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <table id="table" data-toggle="table" data-height="460" data-ajax="ajaxRequest" data-search="true" data-side-pagination="server" data-pagination="true">
            <thead>
                <tr>
                    <th data-field="id">ID</th>
                    <th data-field="name">Item Name</th>
                    <th data-field="price">Item Price</th>
                </tr>
            </thead>
        </table>

        <script>
            // your custom ajax request here
            function ajaxRequest(params) {
                var url = 'https://examples.wenzhixin.net.cn/examples/bootstrap_table/data'
                $.get(url + '?' + $.param(params.data)).then(function(res) {
                    params.success(res)
                })
            }
        </script>
    </div>
</div>