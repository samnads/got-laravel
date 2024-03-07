@extends('components.layouts.vendor-login', ['body_css_class' => 'vendor'])
@section('title', 'Vendor Login')
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/admin/images/logo.png') }}">
                            </div>
                            <h4>Hello! Welcome to got....</h4>
                            <h6 class="font-weight-light">Login in to explore...</h6>
                            <form class="pt-3" id="admin-login" method="POST" action="{{ route('vendor.do-login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Username" name="username" value="vendor@example.com">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" placeholder="Password" name="password" value="12345">
                                </div>
                                <div class="mt-3">
                                        <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
@endsection
@push('link-styles')
    <!-- Pushed Link Styles -->
@endpush
@push('inline-styles')
    <!-- Pushed Inline Styles -->
@endpush
@push('link-scripts')
    <!-- Pushed Link Scripts -->
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
