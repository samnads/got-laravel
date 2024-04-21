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

