@extends('layouts.vendor', ['body_css_class' => ''])
@section('title', 'All Orders')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Orders</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Orders</li>
                    <li class="breadcrumb-item active" aria-current="page">All</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="d-flex justify-content-end mb-3">
        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh" type="button" class="btn btn-sm btn-light border" data-action="dt-refresh"><i class="bx bx-refresh"></i>
        </button>
        <div class="bd-highlight">
            <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search By Status" class="form-select form-select-sm" name="filter_order_status_id">
                <option value="" selected>-- Any Status --</option>
                @foreach ($order_statuses as $key => $order_status)
                    <option value="{{ $order_status->id }}">{{ $order_status->labelled }}</option>
                @endforeach
            </select>
        </div>
        <div class="bd-highlight">
        </div>
        <div class="bd-highlight"></div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="my-products" class="table table-striped table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Order Ref.</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Payment Mode</th>
                            <th>Payment Status</th>
                            <th>Order Amount</th>
                            <th>Progress</th>
                            <th>Order Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Order Ref.</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Payment Mode</th>
                            <th>Payment Status</th>
                            <th>Order Amount</th>
                            <th>Progress</th>
                            <th>Order Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @include('vendor.orders.popup-order-status-change')
    @include('vendor.orders.popup-order-details')
@endsection
@push('link-styles')
    <!-- Pushed Link Styles -->
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/plugins/tom-select/tom-select.min.css?v=') . config('version.vendor_assets') }}" rel="stylesheet">
@endpush
@push('inline-styles')
    <!-- Pushed Inline Styles -->
@endpush
@push('link-scripts')
    <!-- Pushed Link Scripts -->
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('assets/vendor/plugins/tom-select/tom-select.complete.js?v=') . config('version.vendor_assets') }}"></script>
    <script src="{{ asset('assets/vendor/js/orders/orders-list.js?v=') . config('version.vendor_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
