let profile_edit_from = $('form[id="profile_edit_from"]');
$(document).ready(function () {
    profile_edit_from_validator = profile_edit_from.validate({
        focusInvalid: true,
        ignore: [],
        rules: {
            "vendor_name": {
                required: true,
            },
            "owner_name": {
                required: true,
            },
            "gst_number": {
                required: true,
            },
            "email": {
                required: false,
            },
            "mobile_number": {
                required: true,
            },
            "address": {
                required: true,
            },
        },
        messages: {},
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            let submit_btn = $('button[type="submit"]', form);
            submit_btn.prop("disabled", true);
            $.ajax({
                type: 'PUT',
                url: _base_url + 'profile',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: profile_edit_from.serialize(),
                success: function (response) {
                    if (response.status == true) {
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
                                location.reload();
                            }
                        });
                    } else {
                        toastStatusFalse(response, { stack: 1 });
                        submit_btn.prop("disabled", false);
                    }
                },
                error: function (response) {
                    submit_btn.prop("disabled", false);
                },
            });
        }
    });
});