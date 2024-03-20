@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Locations')
@section('content')
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div style="display: flex" class="m-3">
                    <h2 class="card-title float-left">Locations List</h4>
                        <div style="margin-left: auto;">
                            <button data-action="new-location" type="button" class="btn btn-inverse-dark btn-icon">
                                <i class="mdi mdi-plus"></i>
                            </button>
                        </div>
                </div>
                <table class="table table-hover table-bordered" id="locations-datatable">
                    <thead class="table-light">
                        <tr>
                            <th>Sl. No.</th>
                            <th>Location</th>
                            <th>State</th>
                            <th>District</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locations as $key => $location)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->state }}</td>
                                <td>{{ $location->district }}</td>
                                <td>
                                    <button data-action="edit-location" data-id="{{ $location->id }}"
                                        class="btn btn-inverse-secondary btn-icon" title="Edit"> <i
                                            class="mdi mdi-pencil"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="new-location-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="padding: 40px;">
                    <a data-dismiss="modal" style="position: absolute; right: 15px; top: 15px;"><button type="button"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
                    <h2 class="modal-title mb-4">New Location</h2>
                    <form action="#" method="post" accept-charset="utf-8"
                        id="new-location-form">
                        @csrf
                        <input type="hidden" name="id" />
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>State</label>
                                    <select class="form-control" name="state_id">
                                        <option value="">-- Select State --</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->state_id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>District</label>
                                    <select class="form-control" name="district_id">
                                        <option value="">-- Select District --</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->district_id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Location name...">
                                </div>
                            </div>
                            <div class="col-12" style="text-align: right;">
                                <button type="submit" class="btn btn-gradient-dark w-100">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div id="edit-location-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="padding: 40px;">
                    <a data-dismiss="modal" style="position: absolute; right: 15px; top: 15px;"><button type="button"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
                    <h2 class="modal-title mb-4">Edit Location</h2>
                    <form action="#" method="post" accept-charset="utf-8"
                        id="edit-location-form">
                        @csrf
                        <input type="hidden" name="id" />
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>State</label>
                                    <select class="form-control" name="state_id">
                                        <option value="">-- Select State --</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->state_id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>District</label>
                                    <select class="form-control" name="district_id">
                                        <option value="">-- Select District --</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->district_id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Location name...">
                                </div>
                            </div>
                            <div class="col-12" style="text-align: right;">
                                <button type="submit" class="btn btn-gradient-dark w-100">Save</button>
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
        new DataTable('#locations-datatable');
        let new_location_form = $('form[id="new-location-form"]');
        let edit_location_form = $('form[id="edit-location-form"]');
        var new_location_modal = new bootstrap.Modal(document.getElementById('new-location-modal'), {
            backdrop: 'static',
            keyboard: true
        });
        var edit_location_modal = new bootstrap.Modal(document.getElementById('edit-location-modal'), {
            backdrop: 'static',
            keyboard: true
        })
        $('[data-action="new-location"]').click(function() {
            new_location_modal.show();
        });
        $('[data-action="edit-location"]').click(function() {
            edit_location_modal.show();
        });
        $(document).ready(function() {
            new_location_form.validate({
                focusInvalid: true,
                ignore: [],
                rules: {
                    "state_id": {
                        required: true,
                    },
                    "district_id": {
                        required: true,
                    },
                    "name": {
                        required: true,
                    }
                },
                messages: {
                    "state_id": {
                        required: "Select state",
                    },
                    "district_id": {
                        required: "Select district",
                    },
                    "name": {
                        required: "Enter location name",
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    let formData = new FormData(form);
                    $.ajax({
                        type: 'POST',
                        url: _base_url + "admin/ajax/location",
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if (response.status == "success") {
                                location.href = _base_url + 'admin/locations/list';
                            } else {
                                toast('Error !', response.message, 'error');
                            }
                        },
                        error: function(response) {
                            toast('Error !', 'An error occured !', 'error');
                        },
                    });
                }
            });
        });
    </script>
@endpush
