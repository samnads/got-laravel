<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('vendor/dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-product" aria-expanded="false"
                aria-controls="ui-product">
                <span class="menu-title">Product</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-apple menu-icon"></i>
            </a>
            <div class="collapse" id="ui-product">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('vendor/product/list') }}">My Products</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('vendor/product/add/list') }}">New
                            Product</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-order" aria-expanded="false"
                aria-controls="ui-order">
                <span class="menu-title">Order Management</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-cart menu-icon"></i>
            </a>
            <div class="collapse" id="ui-order">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('vendor/order/pending') }}">Pending Orders</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('vendor/order/completed') }}">Completed</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
