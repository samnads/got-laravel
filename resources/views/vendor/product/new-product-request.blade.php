@extends('layouts.vendor', ['body_css_class' => ''])
@section('title', 'New Product Request')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">New Request</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Product</li>
                    <li class="breadcrumb-item" aria-current="page">Requests</li>
                    <li class="breadcrumb-item active" aria-current="page">New</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body p-4">
            <div class="form-body mt-4">
                <form id="product-request">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="border border-3 p-4 rounded">
                                <div class="mb-3">
                                    <label for="pname" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="pname" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="pcode" class="form-label">Code</label>
                                    <input type="email" class="form-control" id="pcode" name="code">
                                </div>
                                <div class="mb-3">
                                    <label for="vgfd" class="form-label">Description</label>
                                    <textarea class="form-control" id="vgfd" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ghdf" class="form-label">Category</label>
                                        <select placeholder="Search category..." id="ghdf" name="category_id">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jhdf" class="form-label">Brand</label>
                                        <select id="jhdf" placeholder="Search brand..." name="brand_id">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="border border-3 p-4 rounded">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="cfjg" class="form-label">MRP.</label>
                                        <input type="number" class="form-control no-arrow" id="cfjg" name="item_size">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="fdgas" class="form-label">Selling Price</label>
                                        <input type="text" class="form-control" id="fdgas" name="unit_id">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ghwef" class="form-label">Item Size</label>
                                        <input type="number" class="form-control no-arrow" id="ghwef" name="item_size">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gdfs" class="form-label">Unit</label>
                                        <input type="text" class="form-control" id="gdfs" name="unit_id">
                                    </div>
                                    <div class="col-12">
                                        <label for="fdfa" class="form-label">Additional Information</label>
                                        <textarea class="form-control" id="fdfa" rows="3" placeholder="If you need category, brand or other additional requirements, please specify here..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-info">Send Request</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </form>
            </div>
        </div>
    </div>
@endsection
@push('link-styles')
    <!-- Pushed Link Styles -->
    <link href="{{ asset('assets/vendor/plugins/tom-select/tom-select.min.css?v=') . config('version.vendor_assets') }}" rel="stylesheet">
@endpush
@push('inline-styles')
    <!-- Pushed Inline Styles -->
@endpush
@push('link-scripts')
    <!-- Pushed Link Scripts -->
    <script src="{{ asset('assets/vendor/plugins/tom-select/tom-select.complete.js?v=') . config('version.vendor_assets') }}"></script>
    <script src="{{ asset('assets/vendor/js/product/new-request.js?v=') . config('version.vendor_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
