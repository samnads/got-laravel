let order_details_modal = new bootstrap.Modal(document.querySelector('.modal.order-details'), {
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
            data.filter_order_status_id = $('select[name="filter_order_status_id"]').val();
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
        { data: 'order_date_time', name: 'order_date_time' },
        { data: 'vendor', name: 'vendor' },
        { data: 'customer_name', name: 'customer_name' },
        { data: 'customer_mobile_number_1', name: 'customer_mobile_number_1' },
        { data: 'payment_mode', name: 'payment_mode' },
        { data: 'payment_status', name: 'payment_status' },
        { data: 'got_commission', name: 'got_commission' },
        { data: 'total_payable', name: 'total_payable' },
        { data: 'order_status_progess', name: 'order_status_progess' },
        { data: 'order_status', name: 'order_status' },
        { data: 'action_html', name: 'action_html' },
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
            targets: 'order_status_progess:name',
            sortable: false,
            visible: false,
            type: 'html',
            className: "text-center",
        },
        {
            targets: 'order_status:name',
            type: 'html',
            className: "text-center",
            // width: 1
        },
        {
            targets: 'action_html:name',
            type: 'html',
            width: 1
        }
    ],
    drawCallback: function (settings) {
        $('[data-bs-toggle="tooltip"]').tooltip({ trigger: 'hover' });
        createOrderStatusEditListeneer();
        createOrderDetailsListeneer();
    },
});
$('select[name="filter_order_status_id"]').change(function () {
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