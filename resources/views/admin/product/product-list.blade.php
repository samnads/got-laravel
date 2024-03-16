@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Products')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div style="display: flex">
                    <h4 class="card-title float-left">Products</h4>
                    <div style="margin-left: auto;">
                        <a role="button" href="{{ url('admin/product/new') }}"><button type="button"
                                class="btn btn-inverse-dark btn-icon">
                                <i class="mdi mdi-plus"></i>
                            </button></a>
                    </div>
                </div>
                <div class="table-responsiv">
                    <table id="vendor-list" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Product Name</th>
                                <th>Unit</th>
                                <th>Pack Size</th>
                                <th>Thumbnail</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->item_size.' '.$product->unit_code }}</td>
                                    <td><img src="{{ config('url.uploads_cdn') . 'products/' . ($product->thumbnail_image ?: 'default.jpg') }}" />
                                </td>
                                    <td>
                                        <a href="{{url('admin/product/edit/'.$product->id)}}"
                                            class="btn btn-inverse-success btn-icon" title="View" style="padding: 13px;">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        @if($product->deleted_at == null)
                                        <a href="{{url('admin/product/block/'.$product->id)}}"
                                            class="btn btn-inverse-danger btn-icon" title="Block" style="padding: 13px;">
                                            <i class="mdi mdi-block-helper"></i>
                                        </a>
                                        @else
                                        <a href="{{url('admin/product/unblock/'.$product->id)}}"
                                            class="btn btn-inverse-dark btn-icon" title="Unblock" style="padding: 13px;">
                                            <i class="mdi mdi-monitor"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
    <script>
        $(document).ready(function() {
            new DataTable('#vendor-list');
            $('[data-action="delete-brand"]').click(function() {
                let id = $(this).data("id");
                Swal.fire({
                    title: "Delete Brand?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    focusCancel: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: _base_url + "admin/ajax/brand",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.status == "success") {
                                    location.href = _base_url +
                                        'admin/brands';
                                } else {
                                    toast('Error !', response.message, 'error');
                                }
                            },
                            error: function(response) {
                                toast('Error !', response.statusText, 'error');
                            },
                        });
                    }
                });
            });
        });
    </script>
@endpush
