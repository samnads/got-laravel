@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Product Categories')
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
                            <h4 class="card-title float-left">Add Category</h4>
                            <div style="margin-left: auto;">
                                <a href="{{ route('admin.products-categories') }}"><button type="button"
                                        class="btn btn-inverse-dark btn-icon">
                                        <i class="mdi mdi-view-headline"></i>
                                    </button></a>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3">
                            <form id="new-category-form" action="{{ route('admin.save-product-category') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Category">
                                </div>

                                <div class="form-group">
                                    <label for="exampleTextarea1">Category Description</label>
                                    <textarea class="form-control" id="exampleTextarea1"name="description" rows="4"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Thumbnail Image</label>
                                    <input type="file" name="thumbnail" class="form-control">
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-gradient-dark w-100">Save</button>
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
        let _base_url = "{{url('')}}/";

        $(document).ready(function() {
            let new_category_validator = $('#new-category-form').validate({
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
                        required: "Please enter category name",
                    },
                    "description": {
                        required: "Please enter category description",
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    //let submit_btn = $('button[type="submit"]', form);
                    //submit_btn.html(loading_button_html).prop("disabled", true);
                    $.ajax({
                        type: 'POST',
                        url: _base_url + "admin/ajax/product-category/save",
                        //dataType: 'json',
                        data: $('#new-category-form').serialize(),
                        success: function(response) {
                             alert('success');
                        },
                        error: function(response) {
                            console.log($('#new-category-form').serialize());
                            alert('error');
                        },
                    });
                }
            });
        });
    </script>
@endpush
