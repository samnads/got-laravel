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
            data.action = 'datatable';
            data.filter_category_id = $('select[name="filter_category_id"]').val();
            data.filter_brand_id = $('select[name="filter_brand_id"]').val();
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
                        toastStatusFalse(response, { stack: 1 });
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
$('[data-action="dt-refresh"]').click(function () {
    my_products_datatable.draw();
});
$('select[name="filter_category_id"],select[name="filter_brand_id"]').change(function () {
    my_products_datatable.draw();
});
function format(callback, data) {
    // `d` is the original data object for the row
    $.ajax({
        type: 'GET',
        url: _url,
        dataType: 'json',
        data: {
            action: 'variants',
            id: data.id
        },
        success: function (response) {
            let rows_html = ``;
            if (response.status == true) {
                $.each(response.data, function (index, row) {
                    rows_html += `<tr>
                                    <th scope="row">${index + 1}</th>
                                    <td>${row.thumbnail_image_html}</td>
                                    <td>${row.code}</td>
                                    <td>${row.variant_option_name}</td>
                                    <td>${row.item_size}</td>
                                    <td>${row.maximum_retail_price}</td>
                                     <td>${row.status_html}</td>
                                    <td>${row.actions_html}</td>
                                </tr>`;
                });
                rows_html = rows_html || `<tr>
                                <td colspan="8" class="text-danger text-center">There is no variants currently available !</td>
                            </tr>`;
                callback($(`<table class="table table-sm align-middle table-bordered mb-0">
                        <thead>
                            <tr>
                            <th scope="col">Sl. No.</th>
                            <th scope="col">Thumbnail</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Variant</th>
                            <th scope="col">SIze</th>
                            <th scope="col">MRP.</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rows_html}
                        </tbody>
                    </table>`), ['table-secondary', 'p-1']).show();
                productAddListener();
            } else {
                toastStatusFalse(response);
            }
        },
        error: function (response) {
            ajaxError(response);
        },
    });
}
my_products_datatable.on('click', 'td [data-action="show-variants"]', function (e) {
    var tr = $(this).closest('tr');
    let row = my_products_datatable.row(tr);
    if (row.child.isShown()) {
        // This row is already open - close it
        $(tr).removeClass('table-secondary');
        row.child.hide();
    }
    else {
        // Open this row
        my_products_datatable.rows().every(function (rowIdx, tableLoop, rowLoop) {
            if (this.child.isShown()) {
                $(this.node()).removeClass('table-secondary');
                this.child.hide();
                $(this.node()).removeClass('shown');
            }
        });
        $(tr).addClass('table-secondary');
        //row.child(format(row.data()), ['table-info', 'p-3']).show();
        format(row.child, row.data());
    }
});