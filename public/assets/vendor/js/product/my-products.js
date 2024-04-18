let company_list_datatable = new DataTable('#my-products', {
    processing: true,
    serverSide: true,
    "order": [],
    'ajax': {
        dataType: "JSON",
        'url': _url,
        'data': function (data) {
            //data.keywordsearch = $('#search').val();
        },
        "complete": function (json, type) { // data sent from controllerr
            let response = json.responseJSON;
            if (response.status == false) {
                //toast(response.error.title, response.error.content, response.error.type);
            }
        }
    },
    columns: [
        { data: 'slno', name: 'slno' },
        { data: 'brand', name: 'brand' },
        { data: 'name', name: 'name' },
        { data: 'mrp', name: 'mrp' },
        { data: 'selling_price', name: 'selling_price' },
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
        createDeleteListener();
        createUpdateListener();
    }
});