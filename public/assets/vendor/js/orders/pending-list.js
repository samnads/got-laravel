let product_quick_add_modal = new bootstrap.Modal(document.getElementById('quick-add-product'), {
    //backdrop: 'static',
    keyboard: true
});
let product_quick_add_form = $('form[id="quick-add-product"]');
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
        { data: 'order_reference', name: 'order_reference' },
        { data: 'customer_name', name: 'customer_name' },
        { data: 'payment_mode', name: 'payment_mode' },
        { data: 'payment_status', name: 'payment_status' },
        { data: 'total_payable', name: 'total_payable' },
    ],
    columnDefs: [
        {
            targets: 0,
            sortable: false,
            type: 'html'
        },
        {
            targets: 5,
            type: 'num',
            className: "text-end"
        },
        {
            targets: -1,
            sortable: false,
            type: 'html',
            width: 1
        }
    ],
    drawCallback: function (settings) {
        productAddListener();
    },
});
function productAddListener() {
    $('[data-action="add-product"]').click(function () {
        let id = this.getAttribute('data-id');
        $('[name="id"]', product_quick_add_form).val(id);
        $.ajax({
            type: 'GET',
            url: _url,
            dataType: 'json',
            data: {
                id: id,
                action: "product-for-add"
            },
            success: function (response) {
                if (response.status == true) {
                    product_quick_add_form_validator.resetForm();
                    product_quick_add_form.trigger("reset");
                    $('input[name="min_cart_quantity"]', product_quick_add_form).val(1);
                    $('#pname', product_quick_add_form).val(response.data.product.name);
                    $('#pcode', product_quick_add_form).val(response.data.product.code);
                    $('[name="maximum_retail_price"]', product_quick_add_form).val(response.data.product.maximum_retail_price);
                    product_quick_add_modal.show();
                } else {
                    toastStatusFalse(response);
                }
            },
            error: function (response) {
                ajaxError(response);
            },
        });
    });
}
$(document).ready(function () {
    product_quick_add_form_validator = product_quick_add_form.validate({
        focusInvalid: true,
        ignore: [],
        rules: {
            "id": {
                required: true,
            },
            "min_cart_quantity": {
                required: true,
            },
            "max_cart_quantity": {
                required: true,
            },
            "maximum_retail_price": {
                required: true,
            },
            "retail_price": {
                required: true,
            }
        },
        messages: {},
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
        },
        submitHandler: function (form) {
            let submit_btn = $('button[type="submit"]', form);
            submit_btn.html(loading_button_html).prop("disabled", true);
            $.ajax({
                type: 'POST',
                url: _url,
                dataType: 'json',
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                data: product_quick_add_form.serialize(),
                success: function (response) {
                    if (response.status == true) {
                        product_quick_add_modal.hide();
                        toast(response.message.title, response.message.content, response.message.type);
                    } else {
                        toastStatusFalse(response);
                    }
                    submit_btn.html('Save').prop("disabled", false);
                    my_products_datatable.ajax.reload(null, false);
                },
                error: function (response) {
                    ajaxError(response);
                    submit_btn.html('Save').prop("disabled", false);
                    my_products_datatable.ajax.reload(null, false);
                },
            });
        }
    });
});
