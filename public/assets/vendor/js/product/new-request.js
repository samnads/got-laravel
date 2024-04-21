let brand_id_select = new TomSelect('select[name="brand_id"]', {
    maxItems: 1,
    //plugins: ['clear_button'],
    valueField: 'value',
    labelField: 'label',
    searchField: 'label',
    create: false,
    load: function (query, callback) {
        fetch(_base_url + 'dropdown/brands/new-product-request?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(json => {
                callback(json.items);
            }).catch(() => {
                callback();
            });

    },
    render: {
        option: function (item, escape) {
            return `<div class="py-2 d-flex">
							${escape(item.label)}
						</div>`;
        },
        no_results: function (data, escape) {
            return '<div class="no-results">No brands found for "' + escape(data.input) + '"</div>';
        },
        item: function (item, escape) {
            return `<div>${escape(item.label)}</div>`;

        }
    }
});
let category_id_select = new TomSelect('select[name="category_id"]', {
    maxItems: 1,
    //plugins: ['clear_button'],
    valueField: 'value',
    labelField: 'label',
    searchField: 'label',
    create: false,
    load: function (query, callback) {
        fetch(_base_url + 'dropdown/categories/new-product-request?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(json => {
                callback(json.items);
            }).catch(() => {
                callback();
            });

    },
    render: {
        option: function (item, escape) {
            return `<div class="py-2 d-flex">
							${escape(item.label)}
						</div>`;
        },
        no_results: function (data, escape) {
            return '<div class="no-results">No brands found for "' + escape(data.input) + '"</div>';
        },
        item: function (item, escape) {
            return `<div>${escape(item.label)}</div>`;

        }
    }
});
let product_request_form = $('form[id="product-request"]');
$(document).ready(function () {
    product_request_form_validator = product_request_form.validate({
        focusInvalid: true,
        ignore: [],
        rules: {
            "name": {
                required: true,
            },
            "code": {
                required: true,
            },
            "description": {
                required: false,
            },
            "category_id": {
                required: true,
            },
            "brand_id": {
                required: true,
            },
            "maximum_retail_price": {
                required: true,
            },
            "retail_price": {
                required: true,
            },
            "item_size": {
                required: true,
            },
            "unit_id": {
                required: true,
            },
            "additional_information": {
                required: false,
            },
        },
        messages: {},
        errorPlacement: function (error, element) {
            if (element.attr("name") == "category_id" || element.attr("name") == "brand_id") {
                $(element).parent().append(error);
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            let submit_btn = $('button[type="submit"]', form);
            submit_btn.html(loading_button_html).prop("disabled", true);
            $.ajax({
                type: 'PUT',
                url: _url,
                dataType: 'json',
                data: product_quick_edit_form.serialize(),
                success: function (response) {
                    if (response.status == true) {
                        product_quick_edit_modal.hide();
                        toast(response.message.title, response.message.content, response.message.type);
                    } else {
                        toastStatusFalse(response);
                    }
                    submit_btn.html('Update').prop("disabled", false);
                    my_products_datatable.ajax.reload(null, false);
                },
                error: function (response) {
                    submit_btn.html('Update').prop("disabled", false);
                    my_products_datatable.ajax.reload(null, false);
                },
            });
        }
    });
});