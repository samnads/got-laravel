<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-master" aria-expanded="false"
                aria-controls="ui-master">
                <span class="menu-title">Masters</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-master">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/product-categories') }}">Categories</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/product-sub-categories') }}">Sub Categories</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/brands') }}">Brands</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/states') }}">States</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/districts') }}">District</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-vendor" aria-expanded="false"
                aria-controls="ui-vendor">
                <span class="menu-title">Vendor</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-vendor">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/vendors/add') }}">Add Vendor</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/vendors') }}">List
                            Vendors</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('vendors/blocked') }}">Blocked Vendors</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-ads" aria-expanded="false" aria-controls="ui-ad">
                <span class="menu-title">Ads Management</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-ad">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ url('admin/advertisement/requests') }}">Requests</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/advertisement/add') }}">Add
                            Advertisements</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/advertisement/list') }}">List
                            Advertisements</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../../pages/tables/basic-table.html">
                <span class="menu-title">Users</span>
                <i class="mdi mdi-table-large menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
