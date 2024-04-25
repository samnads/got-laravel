<!-- Bootstrap JS -->
<script src="{{ asset('assets/vendor/js/bootstrap.bundle.min.js?v='). config('version.vendor_assets')}}"></script>
<!--plugins-->
<script src="{{ asset('assets/vendor/js/jquery.min.js?v='). config('version.vendor_assets')}}"></script>
<script src="{{ asset('assets/vendor/js/jquery.validate.min.js?v='). config('version.vendor_assets')}}"></script>
<script src="{{ asset('assets/vendor/plugins/simplebar/js/simplebar.min.js?v='). config('version.vendor_assets')}}"></script>
<script src="{{ asset('assets/vendor/plugins/metismenu/js/metisMenu.min.js?v='). config('version.vendor_assets')}}"></script>
<script src="{{ asset('assets/vendor/plugins/perfect-scrollbar/js/perfect-scrollbar.js?v='). config('version.vendor_assets')}}"></script>
<script src="{{ asset('assets/vendor/plugins/jquery-toast/jquery.toast.min.js?v='). config('version.vendor_assets') }}"></script>
<!--app JS-->
<script src="{{ asset('assets/vendor/js/app.js?v='). config('version.vendor_assets')}}"></script>
<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- custom -->
<script src="{{ asset('assets/vendor/js/vendor.js?v='). config('version.vendor_assets') }}"></script>
<script>
    let _base_url = "{{url('vendor')}}/";
    let _url = "{{request()->url()}}";
    let _route = "{{request()->route()->getName()}}";
    @if (Session::get('toast'))
        _toast = {!! json_encode(Session::get('toast')) !!};
    @endif
</script>