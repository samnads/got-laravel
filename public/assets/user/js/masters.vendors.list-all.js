let quick_edit_vendor_modal = new bootstrap.Modal(document.querySelector('.modal.quick-edit-vendor'), {
    backdrop: 'static',
    keyboard: true
});
let quick_edit_vendor_form = $('form[id="quick-edit-vendor"]');
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
        },
        "complete": function () {
        }
    },
    columns: [
        { data: 'slno', name: 'slno' },
        { data: 'name', name: 'name' },
        { data: 'owner', name: 'owner' },
        { data: 'mobile_number', name: 'mobile_number' },
        { data: 'state', name: 'state' },
        { data: 'district', name: 'district' },
        { data: 'location', name: 'location' },
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
            targets: 'status_html:name',
            type: 'html',
            sortable: false,
            width: 1
        },
        {
            targets: 'mobile_number:name',
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
        $.ajax({
            type: 'GET',
            url: _base_url + "masters/vendors/" + id,
            dataType: 'json',
            data: { action: 'quick-edit' },
            success: function (response) {
                if (response.status == true) {
                    quick_edit_vendor_form_validator.resetForm();
                    quick_edit_vendor_form.trigger("reset");
                    //
                    state_id_select.clear();
                    district_id_select.clear();
                    district_id_select.clearOptions();
                    location_id_select.clear();
                    location_id_select.clearOptions();
                    district_id_select.disable();
                    location_id_select.disable();
                    $('[name="id"]', quick_edit_vendor_form).val(id);
                    $('[name="vendor_name"]', quick_edit_vendor_form).val(response.data.vendor.vendor_name);
                    $('[name="owner_name"]', quick_edit_vendor_form).val(response.data.vendor.owner_name);
                    $('[name="mobile_number"]', quick_edit_vendor_form).val(response.data.vendor.mobile_number);
                    $('[name="gst_number"]', quick_edit_vendor_form).val(response.data.vendor.gst_number);
                    $('[name="email"]', quick_edit_vendor_form).val(response.data.vendor.email);
                    $('[name="address"]', quick_edit_vendor_form).val(response.data.vendor.address);
                    $('[name="username"]', quick_edit_vendor_form).val(response.data.vendor.username);
                    if (response.data.vendor.location){
                        state_id_select.setValue([response.data.vendor.state.state_id]);
                        district_id_select.addOption({
                            value: response.data.vendor.district.district_id,
                            label: response.data.vendor.district.name,
                        });
                        district_id_select.setValue([response.data.vendor.location.district_id]);
                        location_id_select.addOption({
                            value: response.data.vendor.location.id,
                            label: response.data.vendor.location.name,
                        });
                        location_id_select.setValue([response.data.vendor.location.id]);
                    }
                    else{

                    }
                    quick_edit_vendor_modal.show();
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
    quick_edit_vendor_form_validator = quick_edit_vendor_form.validate({
        focusInvalid: false,
        ignore: [],
        rules: {
            "id": {
                required: true,
            },
            "vendor_name": {
                required: true,
            },
            "owner_name": {
                required: true,
            },
            "mobile_number": {
                required: true,
            },
            "gst_number": {
                required: false,
            },
            "email": {
                required: false,
            },
            "address": {
                required: true,
            },
            "username": {
                required: true,
            },
            "location_id": {
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
            let formData = new FormData($("#quick-edit-brand")[0]);
            formData.append('_method', 'PUT');
            $.ajax({
                type: 'POST',
                url: _base_url + "masters/brands/" + $('input[name="id"]', quick_edit_vendor_form).val(),
                cache: false,
                dataType: 'json',
                contentType: false,
                processData: false,
                data: formData,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.status == true) {
                        quick_edit_vendor_modal.hide();
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
});
function statusChangeListener() {
    $('[data-action="toggle-status"]').click(function () {
        let id = $(this).attr("data-id");
        let checkbox = this;
        let checkbox_status = $(checkbox).is(':checked');
        let status_text = $(checkbox).is(':checked') ? "Enable" : "Disable";
        Swal.fire({
            title: status_text + " Vendor ?",
            text: "Are you sure want to " + status_text.toLocaleLowerCase() + " this vendor ?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, " + status_text,
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'PUT',
                    url: _base_url + "masters/vendors/" + id,
                    dataType: 'json',
                    headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        action: "toggle-status",
                        status: $(checkbox).is(':checked') ? "enable" : "disable"
                    },
                    success: function (response) {
                        if (response.status == true) {
                            Swal.fire({
                                title: response.message.title,
                                text: response.message.content,
                                icon: "success",
                                didOpen: () => Swal.getConfirmButton().blur()
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
/******************************************************************* */
let state_id_select = new TomSelect('#quick-edit-vendor [name="state_id"]', {
    plugins: {
        'clear_button': {}
    },
    onItemRemove: function (values) {
        district_id_select.clear();
        district_id_select.clearOptions();
        district_id_select.disable();
    },
    onItemAdd: function (values) {
        district_id_select.load('');
        district_id_select.enable();
    },
});
let district_id_select = new TomSelect('#quick-edit-vendor [name="district_id"]', {
    plugins: {
        clear_button: {
        }
    },
    valueField: 'value',
    labelField: 'label',
    searchField: ['label'],
    // fetch remote data
    load: function (query, callback) {
        var url = _base_url + 'dropdown/districts/quick-edit-vendor?' + new URLSearchParams({
            query: encodeURIComponent(query),
            state_id: $('[name="state_id"]', quick_edit_vendor_form).val(),
        })
        fetch(url)
            .then(response => {
                response.json()})
            .then(json => {
                callback(json.items);
            }).catch(() => {
                callback();
            });

    },
    // custom rendering functions for options and items
    render: {
        option: function (item, escape) {
            return `<div class="py-2 d-flex">${escape(item.label)}</div>`;
        },
        no_results: function (data, escape) {
            return '<div class="no-results">No districts found for "' + escape(data.input) + '"</div>';
        },
        item: function (item, escape) {
            return `<div>${escape(item.label)}</div>`;
        }
    },
    onItemRemove: function (values) {
        location_id_select.clear();
        location_id_select.clearOptions();
        location_id_select.disable();
    },
    onDelete: function (values) {
    },
    onItemAdd: function (values) {
        location_id_select.enable();
        location_id_select.load('');
    },
});
let location_id_select = new TomSelect('#quick-edit-vendor [name="location_id"]', {
    plugins: {
        clear_button: {
        }
    },
    valueField: 'value',
    labelField: 'label',
    searchField: ['label'],
    // fetch remote data
    load: function (query, callback) {
        var url = _base_url + 'dropdown/locations/quick-edit-vendor?' + new URLSearchParams({
            query: encodeURIComponent(query),
            district_id: $('[name="district_id"]', quick_edit_vendor_form).val(),
        })
        fetch(url)
            .then(response => response.json())
            .then(json => {
                callback(json.items);
            }).catch(() => {
                callback();
            });

    },
    // custom rendering functions for options and items
    render: {
        option: function (item, escape) {
            return `<div class="py-2 d-flex">${escape(item.label)}</div>`;
        },
        no_results: function (data, escape) {
            return '<div class="no-results">No locations found for "' + escape(data.input) + '"</div>';
        },
        item: function (item, escape) {
            return `<div>${escape(item.label)}</div>`;
        }
    },
    onItemRemove: function (values) {
    },
    onDelete: function (values) {
    },
    onItemAdd: function (values) {
    },
});
