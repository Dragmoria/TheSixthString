<div class="d-flex flex-column flex-grow-1">
    <section class="py-5 text-center container">
        <div class="row">
            <div>
                <h1>Moderate reviews</h1>
            </div>
        </div>
    </section>

    <div>
        <div style="min-height: 460px; visibility: hidden" id="tablecontainer">
            <table class="table" id="table" data-toggle="table" data-height="460" data-ajax="fetchReviews"
                data-search="false" data-side-pagination="server" data-pagination="true" data-filter-control="true"
                data-reorderable-rows="true">
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="title">Title</th>
                        <th data-field="rating" data-sortable="true">Rating</th>
                        <th data-field="status" data-sortable="true">Status</th>
                        <th data-field="createdOn" data-sortable="true">Datum</th>
                        <th data-field="show" data-formatter="showFormatter"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h2 id="reviewTitle"></h2>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <p>Rating: <span id="reviewRating"></span>/5</p>
                            </li>
                            <li class="list-group-item">
                                <p id="reviewContent"></p>
                            </li>
                            <li class="list-group-item">
                                <p id="reviewProductName"></p>
                                <button type="button" id="goToProduct" class="btn btn-primary">Go to product</button>
                            </li>
                            <li class="list-group-item">
                                <p id="reviewStatus"></p>
                            </li>
                            <li class="list-group-item">
                                <p id="reviewCreatedOn"></p>
                            </li>
                            <li class="list-group-item">
                                <p id="reviewId"></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="setReviewStatus(true)" class="btn btn-primary">Accept</button>
                    <button type="button" onclick="setReviewStatus(false)" class="btn btn-warning">Deny</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tablecontainer').css('visibility', 'visible');
    });

    function setReviewStatus(approve) {
        var id = $('#reviewId').text();
        var url = '/ControlPanel/ModerateReviews/SetReviewStatus';

        $.post(url, {
            id: id,
            approve: approve
        }).then(function (res) {
            if (res) {
                $('#modal').modal('hide');
                $('#table').bootstrapTable('refresh');
            }
        })
    }

    function showFormatter(value, row, index) {
        return '<button class="btn btn-primary show-btn" data-index="' + index + '">Show</button>';
    }

    function fetchReviews(params) {
        // volgens documentatie op https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
        var url = '/ControlPanel/ModerateReviews/GetReviewsTableData';

        $.get(url + '?' + $.param(params.data)).then(function (res) {
            params.success(res)
        })
    }

    $(document).on('click', '.show-btn', function () {
        var index = $(this).data('index');
        var row = $('#table').bootstrapTable('getData')[index];

        $('#modal').modal('show');

        $('#reviewTitle').text(row.title);
        $('#reviewRating').text(row.rating);
        $('#reviewContent').text(row.content);
        $('#reviewProductName').text(row.product.name);
        $('#reviewStatus').text(row.status);
        $('#reviewCreatedOn').text(row.createdOn);
        $('#reviewId').text(row.id);

        $('#goToProduct').click(function () {
            window.location.href = '/Product/' + row.product.id;
        });
    })
</script>