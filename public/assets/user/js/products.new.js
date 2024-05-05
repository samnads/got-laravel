let new_product_form = $('form[id="new-product-form"]');
$('[name="have_variations"]', new_product_form).click(function () {
    if (this.value == 1) { // Yes
        $('#size-variants').show();
        $('button[data-action="append-variant"]', new_product_form).show();
    }
    else {
        $('#size-variants').hide();
        $('button[data-action="append-variant"]', new_product_form).hide();
    }
});
$('[name="have_variations"]', new_product_form).trigger('click');
$('button[data-action="append-variant"]', new_product_form).click(function () {
    $('#size-variants').prepend(new_size_variant_html);
});
let new_size_variant_html = '';
$(document).ready(function () {
    new_size_variant_html = $('div[data-row="size-variant"]')[0].outerHTML;
});