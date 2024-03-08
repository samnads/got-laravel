let _toast_title = null;
let _toast_message = null;
let _toast_type = null; 
function toast(heading = 'Success', text = 'Default', type = 'info'){
    $.toast({
        heading: heading,
        text: text,
        icon: type,
        loader: true,
        position: 'bottom-center',
    })
}
$(document).ready(function () {
    if (_toast_message){
        toast(_toast_title, _toast_message, _toast_type);
    }
});