let new_invoice_modal = new bootstrap.Modal(document.querySelector('.modal.new-invoice'), {
    backdrop: 'static',
    keyboard: true
});

let order_status_change_form = $('form[id="order-status-change"]');
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
            data.filter_invoice_status_id = $('select[name="filter_invoice_status_id"]').val();
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
        { data: 'invoice_reference', name: 'invoice_reference' },
        { data: 'vendor_name', name: 'vendor_name' },
        { data: 'for_month', name: 'for_month' },
        { data: 'invoice_date', name: 'invoice_date' },
        { data: 'due_date', name: 'due_date' },
        { data: 'total_payable', name: 'total_payable' },
        { data: 'invoice_status', name: 'invoice_status' },
        { data: 'actions_html', name: 'actions_html' },
    ],
    columnDefs: [
        {
            targets: 'slno:name',
            sortable: false,
            type: 'html'
        },
        {
            targets: 'invoice_status:name',
            type: 'html',
            className: "text-center",
            sortable: false
        },
        {
            targets: 'actions_html:name',
            type: 'html',
            sortable: false,
            width: 1
        }
    ],
    drawCallback: function (settings) {
        $('[data-bs-toggle="tooltip"]').tooltip({ trigger: 'hover' });
        createOrderStatusEditListeneer();
        createOrderDetailsListeneer();
    },
});
$('select[name="filter_invoice_status_id"]').change(function () {
    datatable.draw();
});
$('[data-action="dt-refresh"]').click(function () {
    datatable.draw();
});
function createOrderDetailsListeneer() {
    $('[data-action="order-details"]').click(function () {
        let id = this.getAttribute('data-id');
        $.ajax({
            type: 'GET',
            url: _url,
            dataType: 'json',
            data: {
                id: id,
                action: "order-details"
            },
            success: function (response) {
                if (response.status == true) {
                    let data = response.data;
                    console.log(data);
                    let order_details = $('.order-details');
                    $('.c-name', order_details).html(data.customer.name);
                    $('.c-mobile', order_details).html(data.customer.mobile_number_1);
                    $('.c-address', order_details).html(data.delivery_address.address);
                    $('.o-ref', order_details).html(data.order.order_reference);
                    $('.o-order_date_time', order_details).html(data.order.order_date_time);
                    $('.o-status', order_details).html(data.order_status.labelled);
                    $('.o-service_charge', order_details).html(data.order.got_commission);
                    $('.o-total_payable', order_details).html(data.order.total_payable);
                    let product_rows = '';
                    $.each(data.order_products, function (index, product) {
                        product_rows += `<tr>
                                            <th scope="row">${index + 1}</th>
                                            <td>${product.name}</td>
                                            <td>${product.variant_option_name || '-'}</td>
                                            <td>${product.item_size} ${product.unit_code}</td>
                                            <td>${product.unit_price}</td>
                                            <td>${product.quantity}</td>
                                            <td>${product.total_price}</td>
                                        </tr>`;
                    });
                    $('.order-rows', order_details).html(product_rows);
                    /*new DataTable('#ordered-products', {
                        destroy: true,
                        autoWidth: false,
                        bPaginate: false,
                        dom: 'lrt'
                    });*/
                    order_details_modal.show();
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
function createOrderStatusEditListeneer() {
    $('[data-action="update-order-status"]').click(function () {
        let id = this.getAttribute('data-id');
        $.ajax({
            type: 'GET',
            url: _url,
            dataType: 'json',
            data: {
                id: id,
                action: "update-order-status"
            },
            success: function (response) {
                if (response.status == true) {
                    order_status_change_form.trigger("reset");
                    order_status_change_select.clear();
                    $('[name="id"]', order_status_change_form).val(id);
                    $('[name="order_reference"]', order_status_change_form).val(response.data.order.order_reference);
                    order_status_change_select.setValue([response.data.order.order_status_id]);
                    order_status_change_modal.show();
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
order_status_change_form_validator = order_status_change_form.validate({
    focusInvalid: true,
    ignore: [],
    rules: {
        "id": {
            required: true,
        },
        "order_status_id": {
            required: true,
        }
    },
    messages: {},
    errorPlacement: function (error, element) {
        error.insertAfter(element.parent());
    },
    submitHandler: function (form) {
        let submit_btn = $('button[type="submit"]', form);
        submit_btn.prop("disabled", true);
        $.ajax({
            type: 'PUT',
            url: _base_url + 'orders',
            dataType: 'json',
            data: order_status_change_form.serialize(),
            success: function (response) {
                if (response.status == true) {
                    order_status_change_modal.hide();
                    Swal.fire({
                        title: response.message.title,
                        text: response.message.content,
                        icon: "success",
                        didOpen: () => Swal.getConfirmButton().blur()
                    });
                } else {
                    toastStatusFalse(response);
                }
                submit_btn.prop("disabled", false);
                datatable.ajax.reload(null, false);
            },
            error: function (response) {
                ajaxError(response);
                submit_btn.prop("disabled", false);
                datatable.ajax.reload(null, false);
            },
        });
    }
});
/******************************************************************************** */
let new_invoice_form = $('#new-invoice-form');
new_invoice_form_validator = new_invoice_form.validate({
    focusInvalid: false,
    ignore: [],
    rules: {
        "vendor_id": {
            required: true,
        },
        "for_month": {
            required: true,
        },
        "due_date": {
            required: true,
        }
    },
    messages: {},
    errorPlacement: function (error, element) {
        error.insertAfter(element.parent());
    },
    submitHandler: function (form) {
        let submit_btn = $('button[type="submit"]', form);
        submit_btn.prop("disabled", true);
        $.ajax({
            type: 'POST',
            url: _url,
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            data: new_invoice_form.serialize(),
            success: function (response) {
                if (response.status == true) {
                    new_invoice_modal.hide();
                    Swal.fire({
                        title: response.message.title,
                        text: response.message.content,
                        icon: "success",
                        didOpen: () => Swal.getConfirmButton().blur()
                    });
                } else {
                    toastStatusFalse(response);
                }
                submit_btn.prop("disabled", false);
                datatable.ajax.reload(null, false);
            },
            error: function (response) {
                ajaxError(response);
                submit_btn.prop("disabled", false);
                datatable.ajax.reload(null, false);
            },
        });
    }
});
$('[data-action="new-invoice"]').click(function () {
    let submit_btn = $('button[type="submit"]', new_invoice_form);
    submit_btn.prop("disabled", true);
    vendor_id_select.clear();
    $('table#invoice-line-orders > tbody').empty();
    new_invoice_form_validator.resetForm();
    new_invoice_form.trigger('reset');
    new_invoice_modal.show();
});
let invoice_for_month = $('#new-invoice-form [name="for_month"]').flatpickr({
    plugins: [
        new monthSelectPlugin({
            shorthand: true, //defaults to false
            dateFormat: "Y-m-d", //defaults to "F Y"
            theme: "dark" // defaults to "light"
        })
    ],
    onChange: function (selectedDates, dateStr, instance) {
        getLineItemsForInvoice()
    },
});
let invoice_due_date = $('[name="due_date"]', new_invoice_form).flatpickr({ minDate: "today", });
let vendor_id_select = new TomSelect('.new-invoice [name="vendor_id"]', {
    valueField: 'value',
    labelField: 'label',
    searchField: ['label'],
    create: false,
    maxItems: 1,
    load: function (query, callback) {
        var url = _base_url + 'dropdown/vendors/new-invoice?' + new URLSearchParams({
            query: encodeURIComponent(query),
        })
        fetch(url)
            .then(response => response.json())
            .then(json => {
                callback(json.items);
            }).catch(() => {
                callback();
            });
    },
    render: {
        option: function (item, escape) {
            return `<div class="py-2 d-flex">${escape(item.label)}</div>`;
        },
        no_results: function (data, escape) {
            return '<div class="no-results">No vendors found for "' + escape(data.input) + '"</div>';
        },
        item: function (item, escape) {
            return `<div>${escape(item.label)}</div>`;
        }
    },
    onItemRemove: function (values) {
        getLineItemsForInvoice()
    },
    onItemAdd: function (values) {
        getLineItemsForInvoice()
    },
});
vendor_id_select.load('');
function getLineItemsForInvoice() {
    let submit_btn = $('button[type="submit"]', new_invoice_form);
    submit_btn.prop("disabled", true);
    if ($('[name="for_month"]', new_invoice_form).val() && vendor_id_select.getValue()) {
        $.ajax({
            type: 'GET',
            url: _url,
            dataType: 'json',
            data: {
                action: "get-orders-by-month-for-invoice",
                vendor_id: vendor_id_select.getValue(),
                for_month: $('[name="for_month"]', new_invoice_form).val()
            },
            success: function (response) {
                if (response.status == true) {
                    let rows = '';
                    let got_commission = 0;
                    $.each(response.data.orders, function (index, order) {
                        rows += `<tr>
                        <th scope="row">${index + 1}<input type="hidden" name="order_ids[]" value="${order.id}"/></th>
                        <td>${order.order_reference}</td>
                        <td>${order.os_labelled}</td>
                        <td>${order.order_date}</td>
                        <td>${order.got_commission}</td>
                        </tr>`;
                        got_commission += parseFloat(order.got_commission);
                        submit_btn.prop("disabled", false);
                    });
                    $('[name="total_payable"]', new_invoice_form).val(got_commission)
                    $('table#invoice-line-orders > tbody').html(rows);
                } else {
                    toastStatusFalse(response);
                    submit_btn.prop("disabled", true);
                }
            },
            error: function (response) {
                ajaxError(response);
                submit_btn.prop("disabled", true);
            },
        });
    }
    else {

    }
}