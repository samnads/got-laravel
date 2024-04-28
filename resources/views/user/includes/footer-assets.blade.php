<!-- Bootstrap JS -->
<script src="{{ asset('assets/user/js/bootstrap.bundle.min.js?v='). config('version.user_assets')}}"></script>
<!--plugins-->
<script src="{{ asset('assets/user/js/jquery.min.js?v='). config('version.user_assets')}}"></script>
<script src="{{ asset('assets/user/js/jquery.validate.min.js?v='). config('version.user_assets')}}"></script>
<script src="{{ asset('assets/user/plugins/simplebar/js/simplebar.min.js?v='). config('version.user_assets')}}"></script>
<script src="{{ asset('assets/user/plugins/metismenu/js/metisMenu.min.js?v='). config('version.user_assets')}}"></script>
<script src="{{ asset('assets/user/plugins/perfect-scrollbar/js/perfect-scrollbar.js?v='). config('version.user_assets')}}"></script>
<script src="{{ asset('assets/user/plugins/jquery-toast/jquery.toast.min.js?v='). config('version.user_assets') }}"></script>
<!--app JS-->
<script src="{{ asset('assets/user/js/app.js?v='). config('version.user_assets')}}"></script>
<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- custom -->
<script src="{{ asset('assets/user/js/user.js?v='). config('version.user_assets') }}"></script>
<script>
    let _base_url = "{{url('admin')}}/";
    let _url = "{{request()->url()}}";
    let _route = "{{request()->route()->getName()}}";
    @if (Session::get('toast'))
        _toast = {!! json_encode(Session::get('toast')) !!};
    @endif
</script>