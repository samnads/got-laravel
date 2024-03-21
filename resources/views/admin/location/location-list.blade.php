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
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="padding: 40px;">
                    <a data-dismiss="modal" style="position: absolute; right: 15px; top: 15px;"><button type="button"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
                    <h2 class="modal-title mb-4">New Location</h2>
                    <form action="#" method="post" accept-charset="utf-8" id="new-location-form">
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
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-12" style="text-align: right;">
                                <button type="submit" class="btn btn-gradient-success w-100">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div id="edit-location-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="padding: 40px;">
                    <a data-dismiss="modal" style="position: absolute; right: 15px; top: 15px;"><button type="button"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
                    <h2 class="modal-title mb-4">Edit Location</h2>
                    <form action="#" method="post" accept-charset="utf-8" id="edit-location-form">
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
                                <button type="submit" class="btn btn-gradient-danger w-100">Update</button>
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/css/tom-select.bootstrap5.min.css"
        integrity="sha512-w7Qns0H5VYP5I+I0F7sZId5lsVxTH217LlLUPujdU+nLMWXtyzsRPOP3RCRWTC8HLi77L4rZpJ4agDW3QnF7cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('inline-styles')
    <!-- Pushed Inline Styles -->
@endpush
@push('link-scripts')
    <!-- Pushed Link Scripts -->
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/js/tom-select.complete.js"
        integrity="sha512-96+GeOCMUo6K6W5zoFwGYN9dfyvJNorkKL4cv+hFVmLYx/JZS5vIxOk77GqiK0qYxnzBB+4LbWRVgu5XcIihAQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
    <script>
        new DataTable('#locations-datatable');
        let new_districts_dropdown = new TomSelect('#new-location-form [name="district_id"]', {
            plugins: {
                'clear_button': {}
            },
        });
        let edit_districts_dropdown = new TomSelect('#edit-location-form [name="district_id"]', {
            plugins: {
                'clear_button': {}
            },
        });
        let new_states_dropdown = new TomSelect('#new-location-form [name="state_id"]', {
            plugins: {
                'clear_button': {}
            },
            onChange: function(state_id) {
                new_districts_dropdown.clear();
                new_districts_dropdown.clearOptions();
                $.ajax({
                    type: 'GET',
                    url: _base_url + "admin/ajax/dropdown/get-districts",
                    dataType: 'json',
                    data: {
                        state_id: state_id
                    },
                    success: function(response) {
                        let options = `<option value="">-- Select District --</option>`;
                        $.each(response.items, function(index, item) {
                            options += `<option value="` + item.id + `">` + item.name +
                                `</option>`;
                        });
                        $('#new-location-form [name="district_id"]').html(options);
                        new_districts_dropdown.sync();
                    },
                    error: function(response) {},
                });
            }
        });
        let edit_states_dropdown = new TomSelect('#edit-location-form [name="state_id"]', {
            plugins: {
                'clear_button': {}
            },
            onChange: function(state_id) {
                edit_districts_dropdown.clear();
                edit_districts_dropdown.clearOptions();
                $.ajax({
                    type: 'GET',
                    url: _base_url + "admin/ajax/dropdown/get-districts",
                    dataType: 'json',
                    data: {
                        state_id: state_id
                    },
                    success: function(response) {
                        let options = `<option value="">-- Select District --</option>`;
                        $.each(response.items, function(index, item) {
                            options += `<option value="` + item.id + `">` + item.name +
                                `</option>`;
                        });
                        $('#edit-location-form [name="district_id"]').html(options);
                        edit_districts_dropdown.sync();
                    },
                    error: function(response) {},
                });
            }
        });
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
            edit_districts_dropdown.clear();
            edit_districts_dropdown.clearOptions();
            $.ajax({
                type: 'GET',
                url: _base_url + "admin/ajax/dropdown/get-location",
                dataType: 'json',
                data: {
                    location_id: $(this).data("id")
                },
                success: function(response) {
                    $('#edit-location-form [name="name"]').val(response.location.name);
                    let options = `<option value="">-- Select District --</option>`;
                    $.each(response.items, function(index, item) {
                        options += `<option value="` + item.id + `">` + item.name +
                            `</option>`;
                    });
                    $('#edit-location-form [name="district_id"]').html(options);
                    edit_districts_dropdown.sync();
                    edit_states_dropdown.setValue([response.location.state_id]);
                },
                error: function(response) {},
            });
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
                    if (element.attr("name") == "state_id" || element.attr("name") == "district_id") {
                        $(element).parent().append(error);
                    } else {
                        error.insertAfter(element);
                    }

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
