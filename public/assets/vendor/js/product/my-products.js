let my_products_datatable = new DataTable('#my-products', {
    processing: true,
    serverSide: true,
    "order": [],
    'ajax': {
        dataType: "JSON",
        'url': _url,
        'data': function (data) {
            data.action = 'datatable'
            //data.keywordsearch = $('#search').val();
        },
        "complete": function (json, type) { // data sent from controllerr
            let response = json.responseJSON;
            if (response.status == false) {
                //toast(response.error.title, response.error.content, response.error.type);
            }
        },
        "beforeSend": function () {
            Pace.restart();
        },
        "complete": function () {
            Pace.stop();
        }
    },
    columns: [
        { data: 'slno', name: 'slno' },
        { data: 'brand', name: 'brand' },
        { data: 'name', name: 'name' },
        { data: 'code', name: 'code' },
        { data: 'maximum_retail_price', name: 'maximum_retail_price' },
        { data: 'retail_price', name: 'retail_price' },
        { data: 'action_html', name: 'action_html' }
    ],
    columnDefs: [
        {
            targets: 0,
            sortable: false
        },
        {
            targets: -1,
            sortable: false
        }
    ],
    drawCallback: function (settings) {
        //Pace.stop();
    },
});