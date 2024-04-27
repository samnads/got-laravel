<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/user/images/logo-icon.png?v=') . config('version.vendor_assets') }}"
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
            <a href="{{ route('user.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-spreadsheet"></i>
                </div>
                <div class="menu-title">Masters</div>
            </a>
            <ul>
                <li> <a href="{{ route('user.masters.categories.list') }}"><i
                            class='bx bx-radio-circle'></i>Categories</a>
                </li>
            </ul>
            <ul>
                <li> <a href="{{ route('user.masters.brands.list') }}"><i
                            class='bx bx-radio-circle'></i>Brands</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('user.masters.vendors.list') }}">
                <div class="parent-icon"><i class='bx bx-buildings'></i>
                </div>
                <div class="menu-title">Vendors</div>
            </a>
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
                <div class="parent-icon"><i class="bx bx-cog"></i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
            <ul>
                <li> <a href="javascript:;"><i class='bx bx-radio-circle'></i>Profile</a>
                </li>
                <li> <a href="javascript:;"><i class='bx bx-radio-circle'></i>Order Settings</a>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
