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
            data.filter_category_id = $('select[name="filter_category_id"]').val();
            data.filter_brand_id = $('select[name="filter_brand_id"]').val();
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
        { data: 'thumbnail_image_html', name: 'thumbnail_image_html' },
        { data: 'category', name: 'category' },
        { data: 'brand', name: 'brand' },
        { data: 'name', name: 'name' },
        { data: 'size_label', name: 'size_label' },
        { data: 'code', name: 'code' },
        { data: 'maximum_retail_price', name: 'maximum_retail_price' },
        { data: 'retail_price', name: 'retail_price' },
        { data: 'status_html', name: 'deleted_at' },
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
            'width':1
        },
        {
            targets: 'brand:name',
            type: 'html'
        },
        {
            targets: 'maximum_retail_price:name',
            type: 'num',
            className: "text-end"
        },
        {
            targets: 'retail_price:name',
            type: 'num',
            className: "text-end"
        },
        {
            targets: 'deleted_at:name',
            width: 1
        },
        {
            targets: 'action_html:name',
            sortable: false,
            type: 'html',
            width: 1
        }
    ],
    drawCallback: function (settings) {
        quickEditListener();
        statusChangeListener();
    },
});
function format(callback, data) {
    // `d` is the original data object for the row
    $.ajax({
        type: 'GET',
        url: _url,
        dataType: 'json',
        data: {
            action: 'variants',
            id: data.parent_product_id,
            filter_status : $('select[name="filter_status"]').val()
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
                quickEditListener();
                statusChangeListener();
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
                    product_quick_edit_form_validator.resetForm();
                    product_quick_edit_form.trigger("reset");
                    $('#pname', product_quick_edit_form).val(response.data.product.name);
                    $('#pcode', product_quick_edit_form).val(response.data.product.code);
                    $('[name="min_cart_quantity"]', product_quick_edit_form).val(response.data.product.min_cart_quantity);
                    $('[name="max_cart_quantity"]', product_quick_edit_form).val(response.data.product.max_cart_quantity);
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
function statusChangeListener() {
    $('[data-action="toggle-status"]').click(function () {
        let id = $(this).attr("data-id");
        let checkbox = this;
        let checkbox_status = $(checkbox).is(':checked');
        let status_text = $(checkbox).is(':checked') ? "Enable" : "Disable";
        let status_after = $(checkbox).is(':checked') ? "Enabled" : "Disabled";
        Swal.fire({
            title: status_text + " Product ?",
            text: "Are you sure want to " + status_text + " this product ?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, " + status_text,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'PUT',
                    url: _url,
                    dataType: 'json',
                    headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        id: id,
                        action: "toggle-status",
                        status: $(checkbox).is(':checked') ? "enable" : "disable"
                    },
                    success: function (response) {
                        if (response.status == true) {
                            Swal.fire({
                                title: status_after + " !",
                                text: response.message.content,
                                icon: "success"
                            });
                            my_products_datatable.ajax.reload(null, false);
                        }
                        else{
                            my_products_datatable.ajax.reload(null, false);
                        }
                    },
                    error: function (response) {
                        my_products_datatable.ajax.reload(null, false);
                    },
                });
            }
            else {
                $(checkbox).prop('checked', !checkbox_status);
            }
        });
    });
}
$(document).ready(function () {
    product_quick_edit_form_validator = product_quick_edit_form.validate({
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
                type: 'PUT',
                url: _url,
                dataType: 'json',
                data: product_quick_edit_form.serialize(),
                success: function (response) {
                    if (response.status == true) {
                        product_quick_edit_modal.hide();
                        toast(response.message.title, response.message.content, response.message.type);
                    } else {
                        toastStatusFalse(response);
                    }
                    submit_btn.html('Update').prop("disabled", false);
                    my_products_datatable.ajax.reload(null, false);
                },
                error: function (response) {
                    submit_btn.html('Update').prop("disabled", false);
                    my_products_datatable.ajax.reload(null, false);
                },
            });
        }
    });
});
$('[data-action="dt-refresh"]').click(function () {
    my_products_datatable.draw();
});
$('select[name="filter_category_id"],select[name="filter_brand_id"],select[name="filter_status"]').change(function () {
    my_products_datatable.draw();
});
