let datatable = new DataTable('#datatable', {
    processing: true,
    serverSide: true,
    autoWidth: true,
    "order": [],
    'ajax': {
        dataType: "JSON",
        'url': _url,
        'data': function (data) {
            data.action = 'datatable';
            data.filter_request_status_id = $('select[name="filter_request_status_id"]').val();
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
        { data: 'product_request_reference', name: 'product_request_reference' },
        { data: 'category', name: 'category' },
        { data: 'brand', name: 'brand' },
        { data: 'name', name: 'name' },
        { data: 'code', name: 'code' },
        { data: 'size_label', name: 'size_label' },
        { data: 'maximum_retail_price', name: 'maximum_retail_price' },
        { data: 'product_request_status_html', name: 'product_request_status' },
    ],
    columnDefs: [
        {
            targets: 'slno:name',
            sortable: false,
            type: 'html'
        },
        {
            targets: 'maximum_retail_price:name',
            type: 'num',
            className: "text-end"
        },
        {
            targets: 'product_request_status:name',
            sortable: true,
            type: 'html',
            width: 1
        }
    ],
    drawCallback: function (settings) {
    },
});
/*let filter_request_status_id_select = new TomSelect('select[name="filter_request_status_id"]', {
    create: false,
    allowEmptyOption: true,
    onChange: function (values) {

    }
});*/
$('select[name="filter_request_status_id"]').change(function () {
    datatable.draw();
});
$('[data-action="dt-refresh"]').click(function () {
    datatable.draw();
});