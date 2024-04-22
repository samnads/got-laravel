<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/vendor/images/logo-icon.png?v=') . config('version.vendor_assets') }}"
                class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text"></h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('vendor.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-cart"></i>
                </div>
                <div class="menu-title">Orders</div>
            </a>
            <ul>
                <li> <a href="{{ route('vendor.orders.list') }}"><i
                            class='bx bx-radio-circle'></i>All Orders</a>
                </li>
                <li> <a href="{{ route('vendor.orders.orders_list_by_status_code', ['status_code' => 'pending']) }}"><i
                            class='bx bx-radio-circle'></i>Pending</a>
                </li>
                <li> <a href="{{ route('vendor.orders.orders_list_by_status_code', ['status_code' => 'confirmed']) }}"><i
                            class='bx bx-radio-circle'></i>Accepted</a>
                </li>
                <li> <a href="{{ route('vendor.orders.orders_list_by_status_code', ['status_code' => 'rejected']) }}"><i
                            class='bx bx-radio-circle'></i>Rejected</a>
                </li>
                <li> <a href="{{ route('vendor.orders.orders_list_by_status_code', ['status_code' => 'delayed']) }}"><i
                            class='bx bx-radio-circle'></i>Delayed</a>
                </li>
                <li> <a href="{{ route('vendor.orders.orders_list_by_status_code', ['status_code' => 'completed']) }}"><i
                            class='bx bx-radio-circle'></i>Completed</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Products</div>
            </a>
            <ul>
                <li> <a href="{{ route('vendor.product.my-products') }}"><i class='bx bx-radio-circle'></i>My
                        Products</a>
                </li>
                <li> <a href="{{ route('vendor.product.available-products') }}"><i
                            class='bx bx-radio-circle'></i>Available Products</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Product Requests</div>
            </a>
            <ul>
                <li> <a href="{{ route('vendor.product.requests') }}"><i class='bx bx-radio-circle'></i>My Requests</a>
                </li>
                <li> <a href="{{ route('vendor.product.new-request') }}"><i class='bx bx-radio-circle'></i>New
                        Request</a>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
