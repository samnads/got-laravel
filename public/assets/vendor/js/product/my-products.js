let product_quick_edit_modal = new bootstrap.Modal(document.getElementById('quick-edit-my-product'), {
    //backdrop: 'static',
    keyboard: true
});
let product_quick_edit_form = $('form[id="product-quick-edit"]');
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
            //data.keywordsearch = $('#search').val();
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
            sortable: false,
            width: 1
        }
    ],
    drawCallback: function (settings) {
        quickEditListener();
    },
});
function quickEditListener() {
    $('[data-action="quick-edit-product"]').click(function () {
        let id = this.getAttribute('data-id');
        $('[name="id"]', product_quick_edit_form).val(id);
        $.ajax({
            type: 'GET',
            url: _url,
            dataType: 'json',
            data: {
                id: id,
                action: "quick-edit"
            },
            success: function (response) {
                if (response.status == true) {
                    $('#pname', product_quick_edit_form).val(response.data.product.name);
                    $('#pcode', product_quick_edit_form).val(response.data.product.code);
                    $('[name="maximum_retail_price"]', product_quick_edit_form).val(response.data.product.maximum_retail_price);
                    $('[name="retail_price"]', product_quick_edit_form).val(response.data.product.retail_price);
                    product_quick_edit_modal.show();
                } else {
                    //toastStatusFalse(response);
                }
            },
            error: function (response) {
                //ajaxError(response);
            },
        });
    });
}
