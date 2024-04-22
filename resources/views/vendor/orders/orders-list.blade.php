@extends('layouts.vendor', ['body_css_class' => ''])
@section('title', 'Pending Orders')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pending Orders</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Orders</li>
                    <li class="breadcrumb-item active" aria-current="page">Pending</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-sm btn-light border" data-action="dt-refresh"><i class="bx bx-refresh"></i>
        </button>
        <div class="bd-highlight">
            <select class="form-select form-select-sm" name="filter_order_status_id">
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
                        </tr>
                    </tfoot>
                </table>
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
    <script src="{{ asset('assets/vendor/js/orders/orders-list.js?v=') . config('version.vendor_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
