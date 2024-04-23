let new_delivery_person_modal = new bootstrap.Modal(document.querySelector('.modal.new-delivery-person'), {
    //backdrop: 'static',
    keyboard: true
});
let edit_delivery_person_modal = new bootstrap.Modal(document.querySelector('.modal.edit-delivery-person'), {
    //backdrop: 'static',
    keyboard: true
});
let new_delivery_person_form = $('form[id="new-delivery-person"]');
let edit_delivery_person_form = $('form[id="edit-delivery-person"]');
loading_button_html = "Please wait...";
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
        { data: 'code', name: 'code' },
        { data: 'name', name: 'name' },
        { data: 'mobile_number_1', name: 'mobile_number_1' },
        { data: 'action_html', name: 'action_html' },
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
        {
            targets: 'action_html:name',
            sortable: false,
            type: 'html',
            className:"text-center",
            width:1
        },
    ],
    drawCallback: function (settings) {
        rowEditListener();
    },
});
function rowEditListener() {
    $('[data-action="edit-row"]').click(function () {
        let id = this.getAttribute('data-id');
        $('[name="id"]', edit_delivery_person_form).val(id);
        $.ajax({
            type: 'GET',
            url: _base_url + "masters/delivery-persons",
            dataType: 'json',
            data: {
                id: id,
                action: "quick-edit-popup"
            },
            success: function (response) {
                if (response.status == true) {
                    edit_delivery_person_form_validator.resetForm();
                    edit_delivery_person_form.trigger("reset");
                    $('input[name="name"]', edit_delivery_person_form).val(response.data.vendor_delivery_person.name);
                    $('input[name="mobile_number_1"]', edit_delivery_person_form).val(response.data.vendor_delivery_person.mobile_number_1);
                    edit_delivery_person_modal.show();
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
                url: _base_url + "masters/delivery-persons",
                dataType: 'json',
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                data: new_delivery_person_form.serialize(),
                success: function (response) {
                    if (response.status == true) {
                        new_delivery_person_modal.hide();
                        submit_btn.html('Save').prop("disabled", false);
                        Swal.fire({
                            title: response.message.title,
                            text: response.message.content,
                            icon: response.message.type,
                            confirmButtonColor: swal_colors.success_ok,
                            confirmButtonText: "OK",
                            allowOutsideClick: false,
                            didOpen: () => Swal.getConfirmButton().blur()
                        }).then((result) => {
                            if (result.isConfirmed) {
                                datatable.ajax.reload(null, false);
                            }
                        });
                    } else {
                        toastStatusFalse(response, { stack: 1 });
                        submit_btn.html('Save').prop("disabled", false);
                    }
                },
                error: function (response) {
                    submit_btn.html('Save').prop("disabled", false);
                    datatable.ajax.reload(null, false);
                },
            });
        }
    });
    edit_delivery_person_form_validator = edit_delivery_person_form.validate({
        focusInvalid: true,
        ignore: [],
        rules: {
            "id": {
                required: true,
            },
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
                type: 'PUT',
                url: _base_url + "masters/delivery-persons",
                dataType: 'json',
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                data: edit_delivery_person_form.serialize(),
                success: function (response) {
                    if (response.status == true) {
                        edit_delivery_person_modal.hide();
                        submit_btn.html('Update').prop("disabled", false);
                        Swal.fire({
                            title: response.message.title,
                            text: response.message.content,
                            icon: response.message.type,
                            confirmButtonColor: swal_colors.success_ok,
                            confirmButtonText: "OK",
                            allowOutsideClick: false,
                            didOpen: () => Swal.getConfirmButton().blur()
                        }).then((result) => {
                            if (result.isConfirmed) {
                                datatable.ajax.reload(null, false);
                            }
                        });
                    } else {
                        toastStatusFalse(response, { stack: 1 });
                        submit_btn.html('Update').prop("disabled", false);
                    }
                },
                error: function (response) {
                    submit_btn.html('Update').prop("disabled", false);
                    datatable.ajax.reload(null, false);
                },
            });
        }
    });
});