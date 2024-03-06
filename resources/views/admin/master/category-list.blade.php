@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Product Categories')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Product Categories</h4>
                <p class="card-description">List of cateries shown here...</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category #</th>
                            <th>Parent</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Thumbnail</th>
                            <th>Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i <= 10; $i++)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td> Herman Beck </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%"
                                            aria-valuenow="{{ $i + 1 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td> $ 77.99 </td>
                                <td> May 15, 2015 </td>
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
                        @endfor
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
