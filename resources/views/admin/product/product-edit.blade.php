@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Edit Product')
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
                            <h4 class="card-title float-left">Edit Product</h4>
                            <div style="margin-left: auto;">
                                <a href="{{ route('admin.product-list') }}"><button type="button"
                                        class="btn btn-inverse-dark btn-icon">
                                        <i class="mdi mdi-view-headline"></i>
                                    </button></a>
                            </div>
                        </div>
                        <form id="new-product-form" method="POST" enctype="multipart/form-data" action="{{url('admin/product/update')}}">
                            <input type="hidden" name="id" value="{{$product->id}}">
                            <div class="row">
                                <div class="col-sm-6">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="{{$product->name}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input type="text" class="form-control" name="code" value="{{$product->code}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" rows="4" required>{{$product->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Item Size</label>
                                                <input type="text" class="form-control" name="item_size" value="{{$product->item_size}}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Unit</label>
                                                <select class="form-control" name="unit_id" required>
                                                    <option value="">-- Select Unit --</option>
                                                    @foreach ($units as $key => $unit)
                                                        <option value="{{ $unit->id }}" {{$product->unit_id == $unit->id ? 'selected' : ''}}> {{ $unit->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select class="form-control" name="category_id" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach ($categories as $key => $category)
                                                        <option value="{{ $category->id }}" {{$product_category->category_id == $category->id ? 'selected' : ''}}>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail Image</label>
                                        <input type="file" name="thumbnail_image" class="form-control">
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
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
    <script>
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
                        required: "Enter category name",
                    },
                    "description": {
                        required: "Enter category description",
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
                        url: _base_url + "admin/ajax/product/category",
                        //dataType: 'json',
                        data: $('#new-category-form').serialize(),
                        success: function(response) {
                            if (response.status == "success") {
                                location.href = _base_url + 'admin/product/categories';
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
