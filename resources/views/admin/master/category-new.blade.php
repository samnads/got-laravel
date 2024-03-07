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
                                <a href="http://localhost/cloudveins/got/admin/manage_category"><button type="button"
                                        class="btn btn-inverse-dark btn-icon">
                                        <i class="mdi mdi-view-headline"></i>
                                        </button></a>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3">
                            <form enctype="multipart/form-data"
                                method="post" accept-charset="utf-8" action="{{ route('save-product-category') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Enter Category</label>
                                    <input type="text" class="form-control" name="category" placeholder="Enter Category">
                                </div>

                                <div class="form-group">
                                    <label>Upload Category Image</label>
                                    <input type="file" name="Category_image" class="form-control">
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-gradient-dark w-100">Submit</button>
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
@endpush
