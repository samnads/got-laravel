@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Edit Sub Category')
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
                            <h4 class="card-title float-left">Edit Sub Category</h4>
                            <div style="margin-left: auto;">
                                <a href="{{ route('admin.products-sub-categories') }}"><button type="button"
                                        class="btn btn-inverse-dark btn-icon">
                                        <i class="mdi mdi-view-headline"></i>
                                    </button></a>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3">
                            <form id="edit-category-form">
                                @csrf
                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$category->name}}">
                                </div>

                                <div class="form-group">
                                    <label>Parent Category</label>
                                    <select class="form-control" name="parent_id">
                                        <option value="">-- Select Parent Category --</option>
                                        @foreach($parent_categories as $key => $parent_category)
                                        <option value="{{$parent_category->id}}" {{($parent_category->id == $category->parent_id) ? 'selected' : ''}}>{{$parent_category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="description">Category Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4">{{$category->description}}</textarea>
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
            let new_category_validator = $('#edit-category-form').validate({
                focusInvalid: true,
                ignore: [],
                rules: {
                    "name": {
                        required: true,
                    },
                    "parent_id": {
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
                    "parent_id": {
                        required: "Select parent category",
                    },
                    "description": {
                        required: "Enter category description",
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    $.ajax({
                        type: 'PUT',
                        url: _base_url + "admin/ajax/product/sub-category",
                        //dataType: 'json',
                        data: $('#edit-category-form').serialize(),
                        success: function(response) {
                            if (response.status == "success") {
                                location.href = _base_url + 'admin/product/sub-categories';
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
