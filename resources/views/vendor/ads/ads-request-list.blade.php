@extends('layouts.vendor', ['body_css_class' => ''])
@section('title', 'Advertisements')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Ad Requests</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Ads</li>
                    <li class="breadcrumb-item active" aria-current="page">Requests</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="d-flex justify-content-end mb-3">
        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh" type="button"
            class="btn btn-sm btn-light border" data-action="dt-refresh"><i class="bx bx-refresh"></i>
        </button>
        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="New Ad" type="button"
            class="btn btn-sm btn-light border" data-action="new-ad"><i class="bx bx-plus"></i>
        </button>
        <div class="bd-highlight">
            <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search By Status"
                class="form-select form-select-sm" name="filter_status">
                <option value="">-- All --</option>
                <option value="1" selected>Pending</option>
                <option value="2">Approved</option>
                <option value="3">Rejected</option>
            </select>
        </div>
        <div class="bd-highlight">
        </div>
        <div class="bd-highlight"></div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="ads-list" class="table table-striped table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Request Ref.</th>
                            <th>Req. By Vendor</th>
                            <th>Banner</th>
                            <th>Banner URL</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Ad. Ref.</th>
                            <th>Req. By Vendor</th>
                            <th>Banner</th>
                            <th>Banner URL</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @include('vendor.ads.popup-quick-add-ad')
@endsection
@push('link-styles')
    <!-- Pushed Link Styles -->
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/plugins/tom-select/tom-select.min.css?v=') . config('version.user_assets') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/flatpickr.min.css?v=') . config('version.user_assets') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
@endpush
@push('inline-styles')
    <!-- Pushed Inline Styles -->
@endpush
@push('link-scripts')
    <!-- Pushed Link Scripts -->
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('assets/vendor/plugins/tom-select/tom-select.complete.js?v=') . config('version.user_assets') }}">
    </script>
    <script src="{{ asset('assets/vendor/js/flatpickr.js?v=') . config('version.user_assets') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script src="{{ asset('assets/vendor/js/ads/request-list.js?v=') . config('version.user_assets') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush