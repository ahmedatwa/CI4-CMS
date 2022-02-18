
window.addEventListener('DOMContentLoaded', event => {
    const el = document.querySelector("#table-list");

    if (el) {
        var table = $(el).DataTable({
            "conditionalPaging" : true,
            "sDom": 'lrtip',
            "responsive": true,
            "pageLength": 20,
            "lengthMenu": [20, 35, 50, 100],
        });

        /* ===================
        #  Filters
        #  ==================== */

        $('input[name=\'filter_name\']').on('keyup', function () {
            table.column("#filter_name").search(this.value).draw();
        });

        $('input[name=\'filter_email\']').on('keyup', function () {
            table.column("#filter_email").search(this.value).draw();
        });

        $('input[name=\'filter_scheme\']').on('keyup', function () {
            table.column("#filter_scheme").search(this.value).draw();
        });

        $('select[name=\'filter_status\']').on('change', function () {
            if ($(this).val() !== '') {
                table.column("#filter_status").search($(this).val()).draw();
            } else {
                table.columns().search("").draw();
            }
        });

        $('input[name=\'fillter_date_added\']').on('change', function () {
            table.columns("#fillter_date_added").search(this.value).draw();
        });


    }
});