@extends('layouts.vendor', ['body_css_class' => 'admin-class'])
@section('title', 'Order Settings')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Order Settings</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body p-4">
                    <form id="order-settings">
                        <input type="hidden" name="action" value="order-settings-update" />
                        <h5 class="mb-4">Order Settings</h5>
                        <div class="row mb-3">
                            <label for="hjtww" class="col-sm-3 col-form-label">Min. Order Value<rf />
                            </label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
									<input type="number" step="any" class="form-control no-arrow" id="hjtww" name="min_order_value" value="{{$vendor->min_order_value}}"> <span class="input-group-text">INR.</span>
								</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dfaasas" class="col-sm-3 col-form-label">Min. Order Weight<rf />
                            </label>
                            <div class="col-sm-9">
                                 <div class="input-group mb-3">
									<input type="number" class="form-control no-arrow" id="dfaasas" name="min_order_weight" value="{{$vendor->min_order_weight}}"> <span class="input-group-text">Kg.</span>
								</div>
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
    <script src="{{ asset('assets/vendor/js/profile.order-settings.js?v=') . config('version.vendor_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
