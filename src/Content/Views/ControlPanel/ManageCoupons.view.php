<div class="d-flex flex-grow-1">
    <?php echo component(\Http\Controllers\ControlPanel\SidebarComponent::class); ?>



    <div class="d-flex flex-column flex-grow-1">
        <section class="py-5 text-center container">
            <div class="row">
                <div>
                    <h1>Manage vouchers</h1>
                    <p>Beheer alle vouchers</p>
                </div>
            </div>
        </section>

        <div style="min-height: 460px; visibility: hidden" id="tablecontainer">
            <table class="table" id="table" data-toggle="table" data-height="460" data-ajax="fetchVouchers" data-search="true" data-side-pagination="server" data-pagination="true" data-filter-control="true" data-reorderable-rows="true">
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="name" data-sortable="true">Name</th>
                        <th data-field="code" data-sortable="true">Code</th>
                        <th data-field="value" data-sortable="true">Value</th>
                        <th data-field="type" data-filter-control="select">Type</th>
                        <th data-field="startDate" data-sortable="true">Start date</th>
                        <th data-field="endDate" data-sortable="true">End date</th>
                        <th data-field="usageAmount" data-sortable="true">Usage amount</th>
                        <th data-field="maxUsageAmount">Max usage amount</th>
                        <th data-field="active" data-filter-control="select">Active</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    function fetchVouchers(params) {
        // volgens documentatie op https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
        var url = '/ControlPanel/ManageVouchers/GetVouchers';

        $.get(url + '?' + $.param(params.data)).then(function(res) {
            params.success(res)
        })
    }
</script>