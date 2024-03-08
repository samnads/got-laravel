let _toast = null;
function toast(heading = 'Success', text = 'Default', type = 'info') {
    $.toast({
        heading: heading,
        text: text,
        icon: type,
        loader: true,
        position: 'bottom-center',
    })
}
$(document).ready(function () {
    if (_toast) {
        toast(_toast.title, _toast.message, _toast.type);
    }
});