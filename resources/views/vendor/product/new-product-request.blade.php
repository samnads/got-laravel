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
                                    <label for="inputCostPerPrice" class="form-label">Category</label>
                                    <select class="form-select" id="inputVendor">
                                        <option></option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputStarPoints" class="form-label">Brand</label>
                                    <select class="form-select" id="inputVendor">
                                        <option></option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
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
                                    <label for="cfjg" class="form-label">Item Size</label>
                                    <input type="number" class="form-control no-arrow" id="cfjg" name="item_size">
                                </div>
                                <div class="col-md-6">
                                    <label for="fdgas" class="form-label">Unit</label>
                                    <input type="text" class="form-control" id="fdgas" name="unit_id">
                                </div>
                                <div class="col-12">
                                    <label for="inputProductType" class="form-label">Product Type</label>
                                    <select class="form-select" id="inputProductType">
                                        <option></option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputVendor" class="form-label">Vendor</label>
                                    <select class="form-select" id="inputVendor">
                                        <option></option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-info">Send Request</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
            </div>
        </div>
    </div>
@endsection
@push('link-styles')
    <!-- Pushed Link Styles -->
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css" rel="stylesheet">
@endpush
@push('inline-styles')
    <!-- Pushed Inline Styles -->
@endpush
@push('link-scripts')
    <!-- Pushed Link Scripts -->
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('assets/vendor/js/product/new-request.js?v=') . config('version.vendor_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
