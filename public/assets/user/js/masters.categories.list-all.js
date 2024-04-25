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
        { data: 'thumbnail_image_html', name: 'thumbnail_image_html' },
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
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
            targets: 'actions_html:name',
            sortable: false,
            type: 'num',
            width: 1
        },
    ],
    drawCallback: function (settings) {
        rowEditListener();
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
            data:{},
            success: function (response) {
                if (response.status == true) {
                    quick_edit_category_form_validator.resetForm();
                    quick_edit_category_form.trigger("reset");
                    $('input[name="name"]', quick_edit_category_form).val(response.data.category.name);
                    $('input[name="description"]', quick_edit_category_form).val(response.data.category.description);
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