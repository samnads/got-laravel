let new_payment_modal = new bootstrap.Modal(document.querySelector('.modal.new-payment'), {
    backdrop: 'static',
    keyboard: true
});
let new_payment_form = $('form[id="new-payment"]');
$('[data-action="new-payment"]').click(function () {
    new_payment_modal.show();
});
let invoice_id_select = new TomSelect('form[id="new-payment"] [name="invoice_id"]', {
    valueField: 'value',
    labelField: 'label',
    searchField: ['label'],
    create: false,
    maxItems: 1,
    load: function (query, callback) {
        var url = _base_url + 'dropdown/invoices/new-invoice?' + new URLSearchParams({
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
    },
    onItemAdd: function (values) {
    },
});
invoice_id_select.load('');
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
        { data: 'payment_reference', name: 'payment_reference' },
        { data: 'invoice_reference', name: 'invoice_reference' },
        { data: 'vendor_name', name: 'vendor_name' },
        { data: 'for_month', name: 'for_month' },
        { data: 'invoice_date', name: 'invoice_date' },
        { data: 'due_date', name: 'due_date' },
        { data: 'due_date', name: 'due_date' },
        { data: 'paid_amount', name: 'paid_amount' },
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
            visible:false,
            width: 1
        }
    ],
    drawCallback: function (settings) {
        $('[data-bs-toggle="tooltip"]').tooltip({ trigger: 'hover' });
    },
});
$('select[name="filter_invoice_status_id"]').change(function () {
    datatable.draw();
});
$('[data-action="dt-refresh"]').click(function () {
    datatable.draw();
});
new_payment_form_validator = new_payment_form.validate({
    focusInvalid: true,
    ignore: [],
    rules: {
        "invoice_id": {
            required: true,
        },
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