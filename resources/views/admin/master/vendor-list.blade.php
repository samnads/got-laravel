@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Vendors')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div style="display: flex">
                    <h4 class="card-title float-left">Vendors</h4>
                    <div style="margin-left: auto;">
                        <a role="button" href="{{ url('admin/vendor/new') }}"><button type="button"
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
                                <th>Vendor Name</th>
                                <th>Mobile Number</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $key => $vendor)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $vendor->vendor_name }}</td>
                                    <td>{{ $vendor->mobile_number }}</td>
                                    <td>{{ $vendor->district_id }}</td>
                                    <td>{{ $vendor->district_id }}</td>
                                    <td>{{ $vendor->location_id }}</td>
                                    <td>
                                        <!--<a href="http://localhost/cloudveins/got/admin/view_vendor/33"
                                            class="btn btn-inverse-success btn-icon" title="View" style="padding: 13px;">
                                            <i class="mdi mdi-eye"></i>
                                        </a>-->
                                        @if($vendor->blocked_at == null)
                                        <a href="{{url('admin/vendor/block/'.$vendor->id)}}"
                                            class="btn btn-inverse-danger btn-icon" title="Block" style="padding: 13px;">
                                            <i class="mdi mdi-block-helper"></i>
                                        </a>
                                        @else
                                        <a href="{{url('admin/vendor/unblock/'.$vendor->id)}}"
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
