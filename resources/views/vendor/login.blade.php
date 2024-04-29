<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon
    <link rel="icon" href="{{ asset('assets/vendor/images/favicon-32x32.png') }}" type="image/png" />-->
    <!--plugins-->
    <link href="{{ asset('assets/vendor/plugins/simplebar/css/simplebar.css?v=') . config('version.vendor_assets') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/plugins/perfect-scrollbar/css/perfect-scrollbar.css?v=') . config('version.vendor_assets') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/plugins/metismenu/css/metisMenu.min.css?v=') . config('version.vendor_assets') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets/vendor/css/pace.css?v=') . config('version.vendor_assets') }}" rel="stylesheet" />
    <script src="{{ asset('assets/vendor/js/pace.min.js?v=') . config('version.vendor_assets') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/vendor/css/bootstrap.min.css?v=') . config('version.vendor_assets') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/bootstrap-extended.css?v=') . config('version.vendor_assets') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/app.css?v=') . config('version.vendor_assets') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/icons.css?v=') . config('version.vendor_assets') }}" rel="stylesheet">
    <!-- Toast -->
    <link href="{{ asset('assets/vendor/css/jquery.toast.min.css') }}" rel="stylesheet">
    <title>GOT | Vendor Login</title>
</head>

<body class="">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="card mb-0 border border-info">
                            <div class="card-body">
                                <div class="p-4">
                                    <div class="mb-3 text-center">
                                        <img src="{{ asset('assets/vendor/images/logo-icon.png') }}" width="180"
                                            alt="" />
                                    </div>
                                    <div class="text-center mb-4">
                                        <h5 class="">Vendor Login</h5>
                                        <p class="mb-0">Please log in to your account</p>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" id="login-form">
                                            @csrf
                                            <div class="col-12">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username"
                                                    name="username" placeholder="Enter username">
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0"
                                                        id="password" placeholder="Enter Password" name="password"> <a
                                                        href="javascript:;" class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" name="remember_me" value="1">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckChecked">Remember Me</label>
                                                </div>
                                            </div>
                                            <!--<div class="col-md-6 text-end"> <a
                                                    href="authentication-forgot-password.html">Forgot Password ?</a>
                                            </div>-->
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">Sign in</button>
                                                </div>
                                            </div>
                                            <!--<div class="col-12">
                                                <div class="text-center ">
                                                    <p class="mb-0">Don't have an account yet? <a
                                                            href="authentication-signup.html">Sign up here</a>
                                                    </p>
                                                </div>
                                            </div>-->
                                        </form>
                                    </div>
                                    <!--<div class="login-separater text-center mb-5"> <span>OR SIGN IN WITH</span>
                                        <hr />
                                    </div>
                                    <div class="list-inline contacts-social text-center">
                                        <a href="javascript:;"
                                            class="list-inline-item bg-facebook text-white border-0 rounded-3"><i
                                                class="bx bxl-facebook"></i></a>
                                        <a href="javascript:;"
                                            class="list-inline-item bg-twitter text-white border-0 rounded-3"><i
                                                class="bx bxl-twitter"></i></a>
                                        <a href="javascript:;"
                                            class="list-inline-item bg-google text-white border-0 rounded-3"><i
                                                class="bx bxl-google"></i></a>
                                        <a href="javascript:;"
                                            class="list-inline-item bg-linkedin text-white border-0 rounded-3"><i
                                                class="bx bxl-linkedin"></i></a>
                                    </div>-->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/vendor/js/bootstrap.bundle.min.js?v=') . config('version.vendor_assets') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/vendor/js/jquery.min.js?v=') . config('version.vendor_assets') }}"></script>
    <script src="{{ asset('assets/vendor/js/jquery.validate.min.js?v=') . config('version.vendor_assets') }}"></script>
    <script src="{{ asset('assets/vendor/plugins/simplebar/js/simplebar.min.js?v=') . config('version.vendor_assets') }}"></script>
    <script src="{{ asset('assets/vendor/plugins/metismenu/js/metisMenu.min.js?v=') . config('version.vendor_assets') }}"></script>
    <script src="{{ asset('assets/vendor/plugins/perfect-scrollbar/js/perfect-scrollbar.js?v=') . config('version.vendor_assets') }}"></script>
    <script src="{{ asset('assets/vendor/js/jquery.toast.min.js?v=') . config('version.vendor_assets') }}"></script>
    <!--Password show & hide js -->
    <script>
        let _base_url = "{{ url('') }}/";
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <script src="{{ asset('assets/vendor/js/app.js?v=') . config('version.vendor_assets') }}"></script>
    <script src="{{ asset('assets/vendor/js/vendor.js?v=') . config('version.vendor_assets') }}"></script>
    <script src="{{ asset('assets/vendor/js/login.js?v=') . config('version.vendor_assets') }}"></script>
</body>

</html>
