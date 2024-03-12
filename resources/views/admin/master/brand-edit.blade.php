@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Edit Brand')
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
                            <h4 class="card-title float-left">Edit Brand</h4>
                            <div style="margin-left: auto;">
                                <a href="{{ route('admin.brands') }}"><button type="button"
                                        class="btn btn-inverse-dark btn-icon">
                                        <i class="mdi mdi-view-headline"></i>
                                    </button></a>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3">
                            <form id="edit-brand-form">
                                @csrf
                                <input type="hidden" name="id" value="{{$brand->id}}">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$brand->name}}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Category Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4">{{$brand->description}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Thumbnail Image</label>
                                    <input type="file" name="thumbnail" class="form-control">
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-gradient-dark w-100">Update</button>
                                </div>
                            </form>
                        </div>

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
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
    <script>
        $(document).ready(function() {
            let edit_brand_validator = $('#edit-brand-form').validate({
                focusInvalid: true,
                ignore: [],
                rules: {
                    "name": {
                        required: true,
                    },
                    "description": {
                        required: true,
                    }
                },
                messages: {
                    "name": {
                        required: "Please enter brand name",
                    },
                    "description": {
                        required: "Please enter brand description",
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    $.ajax({
                        type: 'PUT',
                        url: _base_url + "admin/ajax/brand",
                        //dataType: 'json',
                        data: $('#edit-brand-form').serialize(),
                        success: function(response) {
                            if (response.status == "success") {
                                location.href = _base_url + 'admin/brands';
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
    </script>
@endpush
