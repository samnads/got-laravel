@extends('layouts.vendor', ['body_css_class' => ''])
@section('title', 'My Products')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">My Products</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Product</li>
                    <li class="breadcrumb-item active" aria-current="page">My Products</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="d-flex justify-content-end mb-3">
        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh" type="button"
            class="btn btn-sm btn-light border" data-action="dt-refresh"><i class="bx bx-refresh"></i>
        </button>
        <div class="bd-highlight">
            <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search By Category"
                class="form-select form-select-sm" name="filter_category_id">
                <option value="" selected>-- All Categories --</option>
                @foreach ($product_categories as $key => $product_category)
                    <option value="{{ $product_category->value }}">{{ $product_category->label }}</option>
                @endforeach
            </select>
        </div>
        <div class="bd-highlight">
            <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search By Brand"
                class="form-select form-select-sm" name="filter_brand_id">
                <option value="" selected>-- All Brands --</option>
                @foreach ($brands as $key => $brand)
                    <option value="{{ $brand->value }}">{{ $brand->label }}</option>
                @endforeach
            </select>
        </div>
        <div class="bd-highlight">
            <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search By Status"
                class="form-select form-select-sm" name="filter_status">
                <option value="">-- Any Status --</option>
                <option value="1" selected>Active</option>
                <option value="0">Disabled</option>
            </select>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="my-products" class="table table-striped table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Thumbnail</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Product Name</th>
                            <th>Size</th>
                            <th>Code / SKU</th>
                            <th>MRP.</th>
                            <th>Selling Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Thumbnail</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Product Name</th>
                            <th>Size</th>
                            <th>Code</th>
                            <th>MRP.</th>
                            <th>Selling Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @include('vendor.product.popups.quick-edit-my-product')
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
    <script src="{{ asset('assets/vendor/js/product/my-products.js?v=') . config('version.vendor_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
