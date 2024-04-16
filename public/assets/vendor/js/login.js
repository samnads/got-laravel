let login_form = $('form[id="login-form"]');
let loading_button_html = `Please wait...`;
$(document).ready(function () {
    login_form_validator = login_form.validate({
        focusInvalid: true,
        errorClass: "text-danger small",
        ignore: [],
        rules: {
            "username": {
                required: true,
            },
            "password": {
                required: true,
            },
        },
        messages: {
            "username": {
                required: "Enter your username",
            },
            "password": {
                required: "Enter your password",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "password") {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            let submit_btn = $('button[type="submit"]', form);
            submit_btn.html(loading_button_html).prop("disabled", true);
            Pace.restart();
            $.ajax({
                type: 'POST',
                url: _base_url + "login",
                dataType: 'json',
                data: login_form.serialize(),
                success: function (response) {
                    if (response.status == "success") {
                        submit_btn.html('Logging in...').prop("disabled", true).removeClass('btn-info').addClass('btn-success');
                        location.href = response.redirect;
                    }
                    else {
                        submit_btn.html('Login').prop("disabled", false);
                        $.toast({
                            heading: 'Invalid Login',
                            text: response.message,
                            icon: 'error',
                            loader: true,
                            loaderBg: '#fecd00',
                            position: 'bottom-center',
                            stack: false,
                            hideAfter: 2000,
                            allowToastClose: false
                        });
                    }
                    Pace.stop();
                },
                error: function (response) {
                    submit_btn.html('Login').prop("disabled", false);
                    $.toast({
                        heading: 'Invalid Login',
                        text: response.statusText,
                        icon: 'error',
                        loader: true,
                        loaderBg: '#fecd00',
                        position: 'bottom-center',
                        stack: false,
                        hideAfter: 2000,
                        allowToastClose: false
                    });
                    Pace.stop();
                },
            });
        }
    });
});
