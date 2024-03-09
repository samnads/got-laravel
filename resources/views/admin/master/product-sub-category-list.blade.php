@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Product Categories')
@section('content')
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div style="display: flex" class="m-3">
                    <h2 class="card-title float-left">Category List</h4>
                        <div style="margin-left: auto;">
                            <a role="button" href="{{ url('admin/product-category/new') }}"><button type="button"
                                    class="btn btn-inverse-dark btn-icon">
                                    <i class="mdi mdi-plus"></i>
                                </button></a>
                        </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category #</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Description</th>
                            <th>Thumbnail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key => $category)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{$category->name}}</td>
                            <td>{{@$category->parent->name}}</td>
                            <td>{{$category->description}}</td>
                            <td>~</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-info">
                                        <i class="mdi mdi-grease-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-success">
                                        <i class="mdi mdi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
