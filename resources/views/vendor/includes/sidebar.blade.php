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
                <li> <a href="{{ route('vendor.orders.list') }}"><i class='bx bx-radio-circle'></i>All Orders</a>
                </li>
                <!--<li> <a href="{{ route('vendor.orders.orders_list_by_status_code', ['status_code' => 'created']) }}"><i
                            class='bx bx-radio-circle'></i>Pending</a>
                </li>-->
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
                <div class="parent-icon"><i class="bx bx-layer-plus"></i>
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
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-spreadsheet"></i>
                </div>
                <div class="menu-title">Masters</div>
            </a>
            <ul>
                <li> <a href="{{ route('vendor.masters.delivery-persons.list') }}"><i
                            class='bx bx-radio-circle'></i>Delivery Persons</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fadeIn animated bx bx-money"></i>
                </div>
                <div class="menu-title">Accounts</div>
            </a>
            <ul>
                <li> <a href="{{ route('vendor.accounts.invoices') }}"><i class='bx bx-radio-circle'></i>Invoices</a>
                </li>
                <li> <a href="{{ route('vendor.accounts.payments') }}"><i class='bx bx-radio-circle'></i>Payments</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-cog"></i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
            <ul>
                <li> <a href="{{ route('vendor.profile.view') }}"><i class='bx bx-radio-circle'></i>Profile</a>
                </li>
                <li> <a href="{{ route('vendor.profile.update-password') }}"><i class='bx bx-radio-circle'></i>Change Password</a>
                </li>
                <li> <a href="{{ route('vendor.profile.order-settings') }}"><i class='bx bx-radio-circle'></i>Order Settings</a>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
