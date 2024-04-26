let quick_edit_category_modal = new bootstrap.Modal(document.querySelector('.modal.quick-edit-category'), {
    //backdrop: 'static',
    keyboard: true
});
let quick_edit_category_form = $('form[id="quick-edit-category"]');
loading_button_html = "Please wait...";
let datatable = new DataTable('#datatable', {
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
        { data: 'thumbnail_image_html', name: 'thumbnail_image_html' },
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        { data: 'status_html', name: 'status_html' },
        { data: 'actions_html', name: 'actions_html' },
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
            width: 1
        },
        {
            targets: 'status_html:name',
            type: 'html',
            sortable: false,
            width: 1
        },
        {
            targets: 'actions_html:name',
            sortable: false,
            type: 'num',
            width: 1
        },
    ],
    drawCallback: function (settings) {
        rowEditListener();
        statusChangeListener();
        $('[data-bs-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });
    },
});
function rowEditListener() {
    $('[data-action="quick-edit"]').click(function () {
        let id = this.getAttribute('data-id');
        $('[name="id"]', quick_edit_category_form).val(id);
        $.ajax({
            type: 'GET',
            url: _base_url + "masters/categories/" + id,
            dataType: 'json',
            data: { action: 'quick-edit' },
            success: function (response) {
                if (response.status == true) {
                    quick_edit_category_form_validator.resetForm();
                    quick_edit_category_form.trigger("reset");
                    $('input[name="name"]', quick_edit_category_form).val(response.data.product_category.name);
                    $('textarea[name="description"]', quick_edit_category_form).val(response.data.product_category.description);
                    quick_edit_category_modal.show();
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
$('select[name="filter_status"]').change(function () {
    datatable.draw();
});
$(document).ready(function () {
    quick_edit_category_form_validator = quick_edit_category_form.validate({
        focusInvalid: true,
        ignore: [],
        rules: {
            "id": {
                required: true,
            },
            "name": {
                required: true,
            },
            "description": {
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
                url: _base_url + "masters/categories/" + $('input[name="id"]', quick_edit_category_form).val(),
                dataType: 'json',
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                data: quick_edit_category_form.serialize(),
                success: function (response) {
                    if (response.status == true) {
                        quick_edit_category_modal.hide();
                        submit_btn.html('Update').prop("disabled", false);
                        datatable.ajax.reload(null, false);
                        Swal.fire({
                            title: response.message.title,
                            text: response.message.content,
                            icon: response.message.type,
                            confirmButtonColor: swal_colors.success_ok,
                            confirmButtonText: "OK",
                            allowOutsideClick: false,
                            didOpen: () => Swal.getConfirmButton().blur()
                        }).then((result) => {
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
}); function statusChangeListener() {
    $('[data-action="toggle-status"]').click(function () {
        let id = $(this).attr("data-id");
        let checkbox = this;
        let checkbox_status = $(checkbox).is(':checked');
        let status_text = $(checkbox).is(':checked') ? "Enable" : "Disable";
        let status_after = $(checkbox).is(':checked') ? "Enabled" : "Disabled";
        Swal.fire({
            title: status_text + " Category ?",
            text: "Are you sure want to " + status_text.toLocaleLowerCase() + " this category ?",
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
                            datatable.ajax.reload(null, false);
                        }
                        else {
                            datatable.ajax.reload(null, false);
                        }
                    },
                    error: function (response) {
                        datatable.ajax.reload(null, false);
                    },
                });
            }
            else {
                $(checkbox).prop('checked', !checkbox_status);
            }
        });
    });
}