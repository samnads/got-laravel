<!-- Bootstrap JS -->
<script src="{{ asset('assets/vendor/js/bootstrap.bundle.min.js')}}"></script>
<!--plugins-->
<script src="{{ asset('assets/vendor/js/jquery.min.js')}}"></script>
<script src="{{ asset('assets/vendor/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{ asset('assets/vendor/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{ asset('assets/vendor/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<!--app JS-->
<script src="{{ asset('assets/vendor/js/app.js')}}"></script>
<script>
    let _base_url = "{{url('vendor')}}/";
    let _url = "{{request()->url()}}";
</script>