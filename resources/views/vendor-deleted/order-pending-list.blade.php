@extends('components.layouts.vendor', ['body_css_class' => 'admin-class'])
@section('title', 'Orders')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div style="display: flex">
                    <h4 class="card-title float-left">Orders</h4>
                    <div style="margin-left: auto;">
                        <a role="button" href="{{ url('vendor/product/add/list') }}"><button type="button"
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
                                <th>Category</th>
                                <th>MRP</th>
                                <th>Selling Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->item_size . ' ' . $product->unit_code }}</td>
                                    <td>{{ $product->category }}</td>
                                    <td>{{ $product->maximum_retail_price }}</td>
                                    <td>{{ $product->retail_price }}</td>
                                    <td>
                                        <input type="hidden" name="product[]" value='{{ @json_encode($product) }}' />
                                        <button type="button" class="btn btn-inverse-success btn-icon" title="View"
                                            style="padding: 13px;" data-action="edit-product">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        @if ($product->deleted_at == null)
                                            <a href="{{ url('vendor/product/delete/' . $product->id) }}"
                                                class="btn btn-inverse-danger btn-icon" title="Block"
                                                style="padding: 13px;">
                                                <i class="mdi mdi-eye-off"></i>
                                            </a>
                                        @else
                                            <a href="{{ url('vendor/product/restore/' . $product->id) }}"
                                                class="btn btn-inverse-dark btn-icon" title="Unblock"
                                                style="padding: 13px;">
                                                <i class="mdi mdi-eye"></i>
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
    <div id="edit-product" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="padding: 40px;">
                    <a data-dismiss="modal" style="position: absolute; right: 15px; top: 15px;"><button type="button"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
                    <h2 class="modal-title mb-4">Edit Product</h2>
                    <form action="{{ url('vendor/product/update') }}" method="post" accept-charset="utf-8"
                        id="edit-product-form">
                        @csrf
                        <input type="hidden" name="id" />
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" class="form-control" name="product_name" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>MRP.</label>
                                    <input type="number" class="form-control" name="maximum_retail_price" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Selling Price</label>
                                    <input type="number" class="form-control" step="any" name="retail_price"
                                        placeholder="Enter Price">
                                </div>
                            </div>
                            <div class="col-12" style="text-align: right;">
                                <button type="submit" class="btn btn-gradient-dark w-100"> Update </button>
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
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
    <script>
        $(document).ready(function() {
            let edit_product_form = $('form[id="edit-product-form"]')
            var edit_product_modal = new bootstrap.Modal(document.getElementById('edit-product'), {
                backdrop: true,
                keyboard: false
            })
            $('[data-action="edit-product"]').click(function() {
                let product = JSON.parse($(this).closest('td').find("input[name='product[]']").val());
                $('[name="id"]', edit_product_form).val(product.id);
                $('[name="product_name"]', edit_product_form).val(product.name);
                $('[name="maximum_retail_price"]', edit_product_form).val(product.maximum_retail_price);
                $('[name="retail_price"]', edit_product_form).val(product.retail_price)
                edit_product_modal.show();
            });
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
