@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Add Vendor')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <!--<div style="display: flex">
                            <h4 class="card-title float-left">Add Vendor</h4>
                            <div style="margin-left: auto;">
                                <a href="{{ route('admin.vendors') }}"><button type="button"
                                        class="btn btn-inverse-dark btn-icon">
                                        <i class="mdi mdi-view-headline"></i>
                                    </button></a>
                            </div>
                        </div>-->
                        <!--<div class="col-md-6 position-relative p-0 mb-3">
                                            <div class="map-search">
                                                <input name="selected_address" placeholder="Seach..." class="text-field us3-address"
                                                    type="hidden">
                                            </div>
                                            <input type="hidden" class="us3-radius" value="0">
                                            <div class="us3" style="height: 300px; width:100%"></div>
                                        </div>-->
                        <form id="new-vendor-form" method="POST" enctype="multipart/form-data"
                            action="{{ url('admin/product') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input type="text" class="form-control" name="latitude" id="latitude">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input type="text" class="form-control" name="longitude" id="longitude">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>GST Number</label>
                                                <input type="text" class="form-control" name="gst_number"">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Vendor Name</label>
                                        <input type="text" class="form-control" name="vendor_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Owner Name</label>
                                        <input type="text" class="form-control" name="owner_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="number" class="form-control" name="mobile_number">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" name="address" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control" name="state_id">
                                            <option value="">-- Select State --</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->state_id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>District</label>
                                        <select class="form-control" name="district_id">
                                            <option value="">-- Select District --</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select class="form-control" name="location_id">
                                            <option value="">-- Select Location --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" name="username">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="">
                                        <button type="submit" class="btn btn-gradient-dark">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=&loading=async">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-locationpicker/0.1.12/locationpicker.jquery.min.js"
        integrity="sha512-KGE6gRUEc5VBc9weo5zMSOAvKAuSAfXN0I/djLFKgomlIUjDCz3b7Q+QDGDUhicHVLaGPX/zwHfDaVXS9Dt4YA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/js/tom-select.complete.js"
        integrity="sha512-96+GeOCMUo6K6W5zoFwGYN9dfyvJNorkKL4cv+hFVmLYx/JZS5vIxOk77GqiK0qYxnzBB+4LbWRVgu5XcIihAQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
    <script>
        let new_states_dropdown = new TomSelect('#new-vendor-form [name="state_id"]', {
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
                        $('#new-vendor-form [name="district_id"]').html(options);
                        new_districts_dropdown.sync();
                    },
                    error: function(response) {},
                });
            }
        });
        let new_locations_dropdown = new TomSelect('#new-vendor-form [name="location_id"]', {
            plugins: {
                'clear_button': {}
            },
        });
        let new_districts_dropdown = new TomSelect('#new-vendor-form [name="district_id"]', {
            plugins: {
                'clear_button': {}
            },
            onChange: function(district_id) {
                new_locations_dropdown.clear();
                new_locations_dropdown.clearOptions();
                $.ajax({
                    type: 'GET',
                    url: _base_url + "admin/ajax/dropdown/get-locations",
                    dataType: 'json',
                    data: {
                        district_id: district_id
                    },
                    success: function(response) {
                        let options = `<option value="">-- Select Location --</option>`;
                        $.each(response.items, function(index, item) {
                            options += `<option value="` + item.id + `">` + item.name +
                                `</option>`;
                        });
                        $('#new-vendor-form [name="location_id"]').html(options);
                        new_locations_dropdown.sync();
                    },
                    error: function(response) {},
                });
            }
        });
        $(document).ready(function() {
            let new_vendor_form = $('#new-vendor-form').validate({
                focusInvalid: true,
                ignore: [],
                rules: {
                    "latitude": {
                        required: true,
                    },
                    "longitude": {
                        required: true,
                    },
                    "gst_number": {
                        required: false,
                    },
                    "email": {
                        required: false,
                    },
                    "vendor_name": {
                        required: true,
                    },
                    "username": {
                        required: true,
                    },
                    "password": {
                        required: true,
                    },
                    "owner_name": {
                        required: true,
                    },
                    "mobile_number": {
                        required: true,
                    },
                    "address": {
                        required: true,
                    },
                    "location_id": {
                        required: true,
                    }
                },
                messages: {},
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "state_id" || element.attr("name") == "district_id"|| element.attr("name") == "location_id") {
                        $(element).parent().append(error);
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    //let submit_btn = $('button[type="submit"]', form);
                    //submit_btn.html(loading_button_html).prop("disabled", true);
                    $.ajax({
                        type: 'POST',
                        url: _base_url + "admin/vendor",
                        //dataType: 'json',
                        data: $('#new-vendor-form').serialize(),
                        success: function(response) {
                            if (response.status == "success") {
                                location.href = _base_url + 'admin/vendor/list';
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
        /*var event_ = null;

            function locationPickr(latitude, longitude) {
                $('.us3').locationpicker({
                    location: {
                        latitude: latitude,
                        longitude: longitude
                    },

                    radius: 0,
                    inputBinding: {
                        latitudeInput: $('#latitude'),
                        longitudeInput: $('#longitude'),
                        radiusInput: $('.us3-radius'),
                        locationNameInput: $('.us3-address')
                    },
                    //markerIcon: _base_url +'images/picker.png',
                    enableAutocomplete: true,
                    onchanged: function(currentLocation, radius, isMarkerDropped) {
                        // Uncomment line below to show alert on each Location Changed event
                        //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
                    }
                });
            }

            function showPosition(position) {
                if (event_) {
                    console.log(event_);
                    event_.type = 'change';
                    $('input[name="latitude"]', _address_from).val(position.coords.latitude).trigger(event_);
                    $('input[name="longitude"]', _address_from).val(position.coords.longitude).trigger(event_);
                } else {
                    $('#latitude').val(position.coords.latitude);
                    $('#longitude').val(position.coords.longitude);
                }
                locationPickr(position.coords.latitude, position.coords.longitude);
            }

            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        $('.us3').locationpicker({
                            location: {
                                latitude: cent_latitude,
                                longitude: cent_longitude
                            },
                            radius: 0,
                            inputBinding: {
                                latitudeInput: $('#latitude'),
                                longitudeInput: $('#longitude'),
                                radiusInput: $('.us3-radius'),
                                locationNameInput: $('.us3-address')
                            },
                            enableAutocomplete: true,
                            onchanged: function(currentLocation, radius, isMarkerDropped) {
                                // Uncomment line below to show alert on each Location Changed event
                                //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
                            }
                        });
                        break;
                    case error.POSITION_UNAVAILABLE:
                        console.log("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        console.log("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        console.log("An unknown error occurred.");
                        break;
                }
            }
            $(document).ready(function() {
                if ($('#latitude').val() == '' || $('#longitude').val() == '') {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(showPosition, showError);
                    } else {
                        x.innerHTML = "Geolocation is not supported by this browser.";
                    }
                } else {
                    locationPickr($('#latitude').val(), $('#longitude').val());
                }
            });*/
    </script>
@endpush
