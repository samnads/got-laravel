@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Edit Vendor')
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
                        <div style="display: flex">
                            <h4 class="card-title float-left">Edit Vendor</h4>
                            <div style="margin-left: auto;">
                                <a href="{{ route('admin.vendors') }}"><button type="button"
                                        class="btn btn-inverse-dark btn-icon">
                                        <i class="mdi mdi-view-headline"></i>
                                    </button></a>
                            </div>
                        </div>
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
                            <input type="hidden" name="id" value="{{$vendor->id}}"/>
                            @csrf
                            <div class="row">
                                <!--<div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input type="text" class="form-control" id="latitude" value="{{$vendor->latitude}}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input type="text" class="form-control" id="longitude" value="{{$vendor->longitude}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>GST Number</label>
                                                <input type="text" class="form-control" name="gst_number" value="{{$vendor->gst_number}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" value="{{$vendor->email}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Vendor Name</label>
                                        <input type="text" class="form-control" name="vendor_name" value="{{$vendor->vendor_name}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Owner Name</label>
                                        <input type="text" class="form-control" name="owner_name" value="{{$vendor->owner_name}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="number" class="form-control" name="mobile_number" value="{{$vendor->mobile_number}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" name="address" rows="4">{{$vendor->address}}</textarea>
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
                                                <input type="text" class="form-control" name="username" value="{{$vendor->username}}">
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
                                        <button type="submit" class="btn btn-gradient-dark">Update</button>
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
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
    <script>
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
                        required: false,
                    },
                    "owner_name": {
                        required: true,
                    },
                    "mobile_number": {
                        required: true,
                    },
                    "address": {
                        required: true,
                    }
                },
                messages: {
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    //let submit_btn = $('button[type="submit"]', form);
                    //submit_btn.html(loading_button_html).prop("disabled", true);
                    $.ajax({
                        type: 'PUT',
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
    </script>
@endpush
