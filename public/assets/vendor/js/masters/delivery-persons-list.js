let new_delivery_person_modal = new bootstrap.Modal(document.querySelector('.modal.new-delivery-person'), {
    //backdrop: 'static',
    keyboard: true
});
let new_delivery_person_form = $('form[id="new-delivery-person"]');
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
        { data: 'name', name: 'name' },
        { data: 'mobile_number_1', name: 'mobile_number_1' },
    ],
    columnDefs: [
        {
            targets: 'slno:name',
            sortable: false,
            type: 'html'
        },
        {
            targets: 'mobile_number_1:name',
            sortable: false,
            type: 'html'
        },
    ],
    drawCallback: function (settings) {
    },
});
$('[data-action="dt-refresh"]').click(function () {
    datatable.draw();
});
$('[data-action="new-delivery-person"]').click(function () {
    new_delivery_person_form_validator.resetForm();
    new_delivery_person_form.trigger("reset");
    new_delivery_person_modal.show();
});
$(document).ready(function () {
    new_delivery_person_form_validator = new_delivery_person_form.validate({
        focusInvalid: true,
        ignore: [],
        rules: {
            "name": {
                required: true,
            },
            "mobile_number_1": {
                required: true,
            },
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
                data: new_delivery_person_form.serialize(),
                success: function (response) {
                    if (response.status == true) {
                        new_delivery_person_modal.hide();
                        toast(response.message.title, response.message.content, response.message.type);
                    } else {
                        toastStatusFalse(response);
                    }
                    submit_btn.html('Update').prop("disabled", false);
                    datatable.ajax.reload(null, false);
                },
                error: function (response) {
                    submit_btn.html('Update').prop("disabled", false);
                    datatable.ajax.reload(null, false);
                },
            });
        }
    });
});