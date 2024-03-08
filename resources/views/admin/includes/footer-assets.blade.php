<!-- plugins:js -->
<script src="{{ asset('assets/admin/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.cookie.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/admin/js/hoverable-collapse.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"
    integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
    integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/admin/js/main.js') }}"></script>
@if(Session::get('message'))
<script>
    _toast_title = {!! Session::get('title') ? "'" . Session::get('title') . "'" : 'null' !!};
    _toast_message = {!! Session::get('message') ? "'" . Session::get('message') . "'" : 'null' !!};
    _toast_type = {!! Session::get('type') ? "'" . Session::get('type') . "'" : 'null' !!};
</script>
@endif
