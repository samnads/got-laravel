@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Locations')
@section('content')
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div style="display: flex" class="m-3">
                    <h2 class="card-title float-left">State List</h4>
                        <!--<div style="margin-left: auto;">
                            <a role="button" href="{{ url('admin/product/category/new') }}"><button type="button"
                                    class="btn btn-inverse-dark btn-icon">
                                    <i class="mdi mdi-plus"></i>
                                </button></a>
                        </div>-->
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>State Name</th>
                            <th>Districts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $key => $state)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $state->name }}</td>
                                <td>
                                    @foreach ($state->districts as $district)
                                        <p>{{ $district->name }}</p>
                                    @endforeach
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
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    focusCancel: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
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
