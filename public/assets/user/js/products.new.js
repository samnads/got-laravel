/***************************************************************************
 *                                                                         *
 *                                                                         *
 *                                                                         *
 *                         Coder : Samnad Sainulabdeen                     *
 *                                                                         *
 *                                                                         *
 *                                                                         *
|**************************************************************************/
let new_product_form = $('form[id="new-product-form"]');
let new_size_variant_html = '';
$(document).ready(function () {
    new_size_variant_html = $('div[data-row="size-variant"]')[0].outerHTML;
    $('[name="have_variations"]', new_product_form).click(function () {
        if (this.value == 1) { // Yes
            $('#size-variants').show();
            $('#no-variants').hide();
            $('button[data-action="append-variant"]', new_product_form).show();
        }
        else {
            $('#size-variants').hide();
            $('#no-variants').show();
            $('button[data-action="append-variant"]', new_product_form).hide();
            $('#size-variants').html(new_size_variant_html); // reset
        }
    });
    $('button[data-action="append-variant"]', new_product_form).click(function () {
        $('#size-variants').prepend(new_size_variant_html);
        $('.variant_codes').each(function (index) {
            $(this).attr('name', 'variant_codes[' + index+']');
            $(this).attr('id', 'variant_code_' + index);
            $(this).closest('div').prev('label').attr('for', 'variant_code_' + index);
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Code is required",
                }
            });
        });
        $('.variant_sizes').each(function (index) {
            $(this).attr('name', 'variant_sizes[' + index + ']');
            $(this).attr('id', 'variant_size_' + index);
            $(this).closest('div').prev('label').attr('for', 'variant_size_' + index);
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Size is required",
                }
            });
        });
        $('.variant_labels').each(function (index) {
            $(this).attr('name', 'variant_labels[' + index + ']');
            $(this).attr('id', 'variant_label_' + index);
            $(this).closest('div').prev('label').attr('for', 'variant_label_' + index);
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Label is required",
                }
            });
        });
        $('.variant_mrps').each(function (index) {
            $(this).attr('name', 'variant_mrps[' + index + ']');
            $(this).attr('id', 'variant_mrp_' + index);
            $(this).closest('div').prev('label').attr('for', 'variant_mrp_' + index);
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "MRP. is required",
                }
            });
        });
        $('.variant_thumbnail_images').each(function (index) {
            $(this).attr('name', 'variant_thumbnail_images[' + index + ']');
            $(this).attr('id', 'variant_thumbnail_image_' + index);
            $(this).closest('div').prev('label').attr('for', 'variant_thumbnail_image_' + index);
            $(this).rules("add", {
                required: false,
                messages: {
                    required: "Thumbail is required",
                }
            });
        });
        removeVariantListener();
    });
    removeVariantListener();
    $('[name="have_variations"]:checked', new_product_form).trigger('click');
    new_product_form_validator = new_product_form.validate({
        focusInvalid: false,
        ignore: [],
        rules: {
            "name": {
                required: true,
            },
            "category_id": {
                required: true,
            },
            "brand_id": {
                required: false,
            },
            "item_size": {
                required: '[name="have_variations"][value="0"]:checked',
            },
            "unit_id": {
                required: true,
            },
            "maximum_retail_price": {
                required: '[name="have_variations"][value="0"]:checked',
            },
            "code": {
                required: '[name="have_variations"][value="0"]:checked',
            },
            "thumbnail_image": {
                required: false,
            },
            "description": {
                required: false,
            },
            "variant_codes[0]": {
                required: '[name="have_variations"][value="1"]:checked',
            },
            "variant_sizes[0]": {
                required: '[name="have_variations"][value="1"]:checked',
            },
            "variant_labels[0]": {
                required: '[name="have_variations"][value="1"]:checked',
            },
            "variant_mrps[0]": {
                required: '[name="have_variations"][value="1"]:checked',
            },
            "variant_thumbnail_images[0]": {
                required: false,
            },
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
        },
        submitHandler: function (form) {
            let submit_btn = $('button[type="submit"]', form);
            submit_btn.prop("disabled", true);
            let formData = new FormData($("#new-product-form")[0]);
            $.ajax({
                type: 'POST',
                url: _base_url + "products/new",
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
let category_id_select = new TomSelect('#new-product-form [name="category_id"]', {
    plugins: ['clear_button'],
    valueField: 'value',
    labelField: 'label',
    searchField: ['label'],
    maxItems: 1,
    load: function (query, callback) {
        var url = _base_url + 'dropdown/categories/quick-add-product?' + new URLSearchParams({
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
            return '<div class="no-results">No districts found for "' + escape(data.input) + '"</div>';
        },
        item: function (item, escape) {
            return `<div>${escape(item.label)}</div>`;
        }
    },
});
category_id_select.load('');
function removeVariantListener() {
    $('[data-action="remove-variant"]').off("click");
    $('[data-action="remove-variant"]', new_product_form).click(function () {
        $(this).closest('[data-row="size-variant"]').remove();
        removeVariantListener();
    });
    let variant_rows = $('[data-row="size-variant"]').length;
    if (variant_rows == 1) {
        $('button[data-action="remove-variant"]').prop("disabled", true);
    }
    else {
        $('button[data-action="remove-variant"]').prop("disabled", false);
    }
}