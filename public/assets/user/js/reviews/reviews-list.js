let datatable = new DataTable('#ads-list', {
    processing: true,
    serverSide: true,
    autoWidth: true,
    "order": [],
    'ajax': {
        dataType: "JSON",
        'url': _url,
        'data': function (data) {
            data.action = 'datatable';
            data.filter_status = $('select[name="filter_status"]').val();
        },
        "complete": function (json, type) { // data sent from controllerr
            let response = json.responseJSON;
            if (response.status == false) {
                //toast(response.error.title, response.error.content, response.error.type);
            }
        },
        "beforeSend": function () {
            //Pace.restart();
        },
        "complete": function () {
            //Pace.stop();
        }
    },
    columns: [
        { data: 'slno', name: 'slno' },
        { data: 'vendor', name: 'vendor' },
        { data: 'review_level_name', name: 'review_level_name' },
        { data: 'customer', name: 'customer' },
        { data: 'review_title', name: 'review_title' },
        { data: 'review', name: 'review' },
        { data: 'date', name: 'date' },
    ],
    columnDefs: [
        {
            targets: 'slno:name',
            sortable: false,
            type: 'html'
        }
    ],
    drawCallback: function (settings) {
    },
});
$('[data-action="dt-refresh"]').click(function () {
    datatable.draw();
});