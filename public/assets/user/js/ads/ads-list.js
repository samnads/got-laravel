let add_adv_modal = new bootstrap.Modal(document.getElementById('quick-add-adv'), {
    backdrop: 'static',
    keyboard: true
});
let add_adv_form = $('form[id="quick-add-adv-form"]');
let datatable = new DataTable('#ads-list', {
    processing: true,
    serverSide: true,
    autoWidth: true,
    "order": [],
    'ajax': {
        dataType: "JSON",
        'url': _url,
        'data': function (data) {
            data.action = 'datatable';
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
        { data: 'ref_code', name: 'ref_code' },
        { data: 'vendor_name', name: 'vendor_name' },
        { data: 'banner_file', name: 'banner_file' },
        { data: 'banner_url', name: 'banner_url' },
        { data: 'from_date', name: 'from_date' },
        { data: 'to_date', name: 'to_date' },
    ],
    columnDefs: [
        {
            targets: 'slno:name',
            sortable: false,
            type: 'html'
        }
    ],
    drawCallback: function (settings) {
    },
});
$('[data-action="new-ad"]').click(function () {
    add_adv_modal.show();
});
$('select[name="filter_status"]').change(function () {
    datatable.draw();
});
$('[data-action="dt-refresh"]').click(function () {
    datatable.draw();
});
add_adv_form_validator = add_adv_form.validate({
    focusInvalid: true,
    ignore: [],
    rules: {
        "name": {
            required: true,
        },
        "vendor_id": {
            required: false,
        },
        "banner_file": {
            required: true,
        },
        "banner_url": {
            required: true,
        },
        "from": {
            required: true,
        },
        "to": {
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
            type: 'POST',
            url: _base_url + 'advertisements/list',
            dataType: 'json',
            data: add_adv_form.serialize(),
            success: function (response) {
                if (response.status == true) {

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
let from_date = $('#quick-add-adv-form [name="from"]').flatpickr({
    theme: "dark",
    enableTime: true,
    altInput: true,
    onChange: function (selectedDates, dateStr, instance) {
    },
});
let to_date = $('#quick-add-adv-form [name="to"]').flatpickr({
    theme: "dark",
    enableTime: true,
    altInput: true,
    onChange: function (selectedDates, dateStr, instance) {
    },
});