let my_products_datatable = new DataTable('#my-products', {
    processing: true,
    serverSide: true,
    autoWidth: true,
    "order": [],
    'ajax': {
        dataType: "JSON",
        'url': _url,
        'data': function (data) {
            data.action = 'datatable'
            data.status_code = status_code;
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
        { data: 'order_reference', name: 'order_reference' },
        { data: 'customer_name', name: 'customer_name' },
        { data: 'customer_mobile_number_1', name: 'customer_mobile_number_1' },
        { data: 'payment_mode', name: 'payment_mode' },
        { data: 'payment_status', name: 'payment_status' },
        { data: 'total_payable', name: 'total_payable' },
        { data: 'order_status', name: 'order_status' },
    ],
    columnDefs: [
        {
            targets: 'slno:name',
            sortable: false,
            type: 'html'
        },
        {
            targets: 'customer_mobile_number_1:name',
            sortable: false,
            type: 'html'
        },
        {
            targets: 'total_payable:name',
            sortable: false,
            type: 'num',
            className: "text-end"
        },
        {
            targets: 'order_status:name',
            type: 'html',
            className: "text-center",
            width: 1
        }
    ],
    drawCallback: function (settings) {
    },
});