@extends('layouts.user', ['body_css_class' => ''])
@section('title', 'Categories')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Categories</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Categories</li>
                    <li class="breadcrumb-item active" aria-current="page">List All</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="d-flex justify-content-end mb-3">
        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh" type="button" class="btn btn-sm btn-light border" data-action="dt-refresh"><i class="bx bx-refresh"></i>
        </button>
        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="New" type="button" class="btn btn-sm btn-light border" data-action="new-category"><i class="bx bx-plus"></i>
        </button>
        <div class="bd-highlight">
            <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search By Status"
                class="form-select form-select-sm" name="filter_status">
                <option value="">-- Any Status --</option>
                <option value="1" selected>Active</option>
                <option value="0">Disabled</option>
            </select>
        </div>
        <div class="bd-highlight"></div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Thumbnail</th>
                            <th>Name</th>
                            <th>Description</th>
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
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @include('user.popups.quick-edit-category')
    @include('user.popups.quick-add-category')
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
    <script src="{{ asset('assets/user/js/masters.categories.list-all.js?v=') . config('version.user_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
