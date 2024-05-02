@extends('layouts.vendor', ['body_css_class' => 'admin-class'])
@section('title', 'Profile')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body p-4">
                    <form id="profile_edit_from">
                        <input type="hidden" name="action" value="profile-update" />
                        <h5 class="mb-4">Profile Details</h5>
                        <div class="row mb-3">
                            <label for="gdfgdg" class="col-sm-3 col-form-label">Vendor Name
                                <rf />
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="gdfgdg" name="vendor_name"
                                    value="{{ $vendor->vendor_name }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ghffs" class="col-sm-3 col-form-label">Owner Name
                                <rf />
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="ghffs" name="owner_name"
                                    value="{{ $vendor->owner_name }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hjfgvf" class="col-sm-3 col-form-label">GSTIN
                                <rf />
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="hjfgvf" name="gst_number"
                                    value="{{ $vendor->gst_number }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pyuxa" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="pyuxa" name="email"
                                    value="{{ $vendor->email }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ngfsw" class="col-sm-3 col-form-label">Phone
                                <rf />
                            </label>
                            <div class="col-sm-9">
                                <input type="hidden" name="mobile_number_cc" value="{{ $vendor->mobile_number_cc }}">
                                <input type="number" class="form-control no-arrow" id="ngfsw" name="mobile_number"
                                    value="{{ $vendor->mobile_number }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="mfggf" class="col-sm-3 col-form-label">Address
                                <rf />
                            </label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="mfggf" rows="3" name="address">{{ $vendor->address }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="gjrwew" class="col-sm-3 col-form-label">Home Delivery Status
                                <rf />
                            </label>
                            <div class="col-sm-9">
                                <select id="input21" class="form-select" id="gjrwew" name="home_delivery_status_id">
                                    <option value="1" {{ $vendor->home_delivery_status_id == 1 ? 'selected' : '' }}>Available</option>
                                    <option value="2" {{ $vendor->home_delivery_status_id == 2 ? 'selected' : '' }}>Not Available</option>
                                </select>
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
    <script src="{{ asset('assets/vendor/js/profile.js?v=') . config('version.vendor_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
