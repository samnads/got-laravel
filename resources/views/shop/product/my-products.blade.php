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
    <h6 class="mb-0 text-uppercase">Products List</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="my-products" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Brand</th>
                            <th>Product Name</th>
                            <th>Code</th>
                            <th>MRP.</th>
                            <th>Selling Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Brand</th>
                            <th>Product Name</th>
                            <th>Code</th>
                            <th>MRP.</th>
                            <th>Selling Price</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@push('link-styles')
    <!-- Pushed Link Styles -->
    <!--<link href="{{ asset('assets/vendor/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">-->
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css" rel="stylesheet">
@endpush
@push('inline-styles')
    <!-- Pushed Inline Styles -->
@endpush
@push('link-scripts')
    <!-- Pushed Link Scripts -->
    <!--<script src="{{ asset('assets/vendor/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('assets/vendor/js/product/my-products.js?v=') . config('version.vendor_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
    <script>
        $(document).ready(function() {
            /*var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');*/
        });
    </script>
@endpush
