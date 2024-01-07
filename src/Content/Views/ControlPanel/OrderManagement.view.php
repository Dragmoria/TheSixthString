<div class="d-flex flex-column flex-grow-1">
    <section class="py-5 text-center container">
        <div class="row">
            <div>
                <h1>Manage orders</h1>
            </div>
        </div>
    </section>

    <div>
        <div style="min-height: 460px; visibility: hidden" id="tablecontainer">
            <table class="table" id="table" data-toggle="table" data-height="460" data-ajax="fetchOrders"
                data-search="false" data-side-pagination="server" data-pagination="true" data-filter-control="true"
                data-reorderable-rows="true">
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="orderItemsCount">Totaal items</th>
                        <th data-field="createdOn" data-sortable="true">Datum</th>
                        <th data-field="orderTotal">Prijs (excl.)</th>
                        <th data-field="orderTax">BTW</th>
                        <th data-field="paymentStatus" data-sortable="true">Betaling</th>
                        <th data-field="shippingStatus" data-sortable="true">Verzend status</th>
                        <th data-field="show" data-formatter="showFormatter"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tablecontainer').css('visibility', 'visible');
    });

    function showFormatter(value, row, index) {
        return '<button class="btn btn-primary show-btn" data-index="' + index + '">Show</button>';
    }

    function fetchOrders(params) {
        // volgens documentatie op https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
        var url = '/ControlPanel/OrderManagement/GetOrdersTableData';

        $.get(url + '?' + $.param(params.data)).then(function (res) {
            params.success(res)
        })
    }

    $(document).on('click', '.show-btn', function () {
        var index = $(this).data('index');
        var row = $('#table').bootstrapTable('getData')[index];

        window.location.href = '/ControlPanel/OrderManagement/' + row.id;
    })
</script>