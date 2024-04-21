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
        { data: 'thumbnail_image_html', name: 'thumbnail_image_html' },
        { data: 'category', name: 'category' },
        { data: 'brand', name: 'brand' },
        { data: 'name', name: 'name' },
        { data: 'size_label', name: 'size_label' },
        { data: 'code', name: 'code' },
        { data: 'maximum_retail_price', name: 'maximum_retail_price' },
        { data: 'action_html', name: 'action_html' }
    ],
    columnDefs: [
        {
            targets: 'slno:name',
            sortable: false,
            type: 'html'
        },
        {
            targets: 'thumbnail_image_html:name',
            sortable: false,
            type: 'html',
            'width': 1
        },
        {
            targets: 'maximum_retail_price:name',
            type: 'num',
            className: "text-end"
        },
        {
            targets: 'action_html:name',
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
                    $('input[name="max_cart_quantity"]', product_quick_add_form).val(10);
                    $('#pname', product_quick_add_form).val(response.data.product.name);
                    $('#pcode', product_quick_add_form).val(response.data.product.code);
                    $('[name="maximum_retail_price"]', product_quick_add_form).val(response.data.product.maximum_retail_price);
                    $('[name="retail_price"]', product_quick_add_form).val(response.data.product.maximum_retail_price);
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
