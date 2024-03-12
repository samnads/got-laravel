@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Product Categories')
@section('content')
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div style="display: flex" class="m-3">
                    <h2 class="card-title float-left">Category List</h4>
                        <div style="margin-left: auto;">
                            <a role="button" href="{{ url('admin/product/category/new') }}"><button type="button"
                                    class="btn btn-inverse-dark btn-icon">
                                    <i class="mdi mdi-plus"></i>
                                </button></a>
                        </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Thumbnail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $category)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>~</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ url('admin/product/category/edit/' . $category->id) }}"
                                            class="btn btn-inverse-success btn-icon" title="Edit" style="padding: 13px;">
                                            <i class="mdi mdi-pencil-box-outline"></i>
                                        </a>
                                        <button data-action="delete-category" data-id="{{ $category->id }}"
                                            class="btn btn-inverse-danger btn-icon" title="Edit" style="padding: 13px;">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
    <script>
        $(document).ready(function() {
            $('[data-action="delete-category"]').click(function() {
                let category_id = $(this).data("id");
                Swal.fire({
                    title: "Delete Category?",
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
                            url: _base_url + "admin/ajax/product/category",
                            data: {
                                category_id: category_id
                            },
                            success: function(response) {
                                if (response.status == "success") {
                                    location.href = _base_url +
                                        'admin/product/categories';
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
