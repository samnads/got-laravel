@extends('components.layouts.admin', ['body_css_class' => 'admin-class'])
@section('title', 'Admin Dashboard')
@section('content')
    <div class="row">
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Vendors <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{ $vendors_count }}</h2>
                    <!--<h6 class="card-text">Increased by 60%</h6>-->
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Products <i
                            class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{ $products_count }}</h2>
                    <!--<h6 class="card-text">Decreased by 10%</h6>-->
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Product Listings <i
                            class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{ $vendor_products_count }}</h2>
                    <!--<h6 class="card-text">Increased by 5%</h6>-->
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Orders <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{ $orders_count }}</h2>
                    <!--<h6 class="card-text">Increased by 60%</h6>-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Orders</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order Ref.</th>
                                    <th>Customer</th>
                                    <th>Vendor</th>
                                    <th>Amount</th>
                                    <th>No. of Products</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>44545454545</td>
                                    <td>
                                        <img src="{{ asset('assets/admin/images/faces/avatar.jpg') }}" class="me-2"
                                            alt="image"> David Grey
                                    </td>
                                    <td> Fund is not recieved </td>
                                    <td>
                                        <label class="badge badge-gradient-success">155.00</label>
                                    </td>
                                    <td>5</td>
                                </tr>
                                <tr>
                                  <td>44545454545</td>
                                    <td>
                                        <img src="{{ asset('assets/admin/images/faces/avatar.jpg') }}" class="me-2"
                                            alt="image"> Stella Johnson
                                    </td>
                                    <td> High loading time </td>
                                    <td>
                                        <label class="badge badge-gradient-success">155.00</label>
                                    </td>
                                    <td>1</td>
      
                                </tr>
                                <tr>
                                  <td>44545454545</td>
                                    <td>
                                        <img src="{{ asset('assets/admin/images/faces/avatar.jpg') }}" class="me-2"
                                            alt="image"> Marina Michel
                                    </td>
                                    <td> Website down for one week </td>
                                    <td>
                                        <label class="badge badge-gradient-success">155.00</label>
                                    </td>
                                    <td>14</td>
                                </tr>
                                <tr>
                                  <td>44545454545</td>
                                    <td>
                                        <img src="{{ asset('assets/admin/images/faces/avatar.jpg') }}" class="me-2"
                                            alt="image"> John Doe
                                    </td>
                                    <td> Loosing control on server </td>
                                    <td>
                                        <label class="badge badge-gradient-success">155.00</label>
                                    </td>
                                    <td>3</td>
                                </tr>
                            </tbody>
                        </table>
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
