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
                        <th data-field="thumnail" data-formatter="thumbnailFormatter">Thumbnail</th>
                        <th data-field="name">Naam</th>
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
</div>

<script>
    $(document).ready(function() {
        $('#tablecontainer').css('visibility', 'visible');
    });

    function fetchCategories(params) {
        // volgens documentatie op https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
        var url = '/ControlPanel/ManageCategories/GetCategoriesTableData';

        $.get(url + '?' + $.param(params.data)).then(function(res) {
            params.success(res)
        })
    }
</script>