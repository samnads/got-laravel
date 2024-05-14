@extends('layouts.user', ['body_css_class' => 'admin-class'])
@section('title', 'Update Password')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Password</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body p-4">
                    <form id="profile_edit_from">
                        <input type="hidden" name="action" value="update-password"/>
                        <h5 class="mb-4">Change Password</h5>
                        <div class="row mb-3">
                            <label for="yyrw" class="col-sm-3 col-form-label">Curent Password
                                <rf />
                            </label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="yyrw" name="current_password" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="yrere" class="col-sm-3 col-form-label">New Password
                                <rf />
                            </label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="yrere" name="new_password" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="gdste" class="col-sm-3 col-form-label">Retype New Password
                                <rf />
                            </label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="gdste" name="new_password_confirm" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-warning px-4">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('link-styles')
    <!-- Pushed Link Styles -->
@endpush
@push('inline-styles')
    <!-- Pushed Inline Styles -->
@endpush
@push('link-scripts')
    <!-- Pushed Link Scripts -->
    <script src="{{ asset('assets/user/js/profile.update-password.js?v=') . config('version.user_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
