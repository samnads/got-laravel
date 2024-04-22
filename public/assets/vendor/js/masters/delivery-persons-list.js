let datatable = new DataTable('#my-products', {
    processing: true,
    serverSide: true,
    autoWidth: true,
    "order": [],
    'ajax': {
        dataType: "JSON",
        'url': _url,
        'data': function (data) {
            data.action = 'datatable';
            data.filter_order_status_id = $('select[name="filter_order_status_id"]').val();
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
        { data: 'name', name: 'name' },
        { data: 'mobile_number_1', name: 'mobile_number_1' },
    ],
    columnDefs: [
        {
            targets: 'slno:name',
            sortable: false,
            type: 'html'
        },
        {
            targets: 'mobile_number_1:name',
            sortable: false,
            type: 'html'
        },
    ],
    drawCallback: function (settings) {
    },
});
$('[data-action="dt-refresh"]').click(function () {
    datatable.draw();
});