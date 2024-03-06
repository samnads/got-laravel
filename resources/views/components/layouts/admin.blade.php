<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>GOT - @yield('title', 'Default')</title>
    @include('admin.includes.head-meta')
    @include('admin.includes.head-assets')
    @stack('link-styles')
    @stack('inline-styles')
</head>

<body {!! @$body_css_class ? 'class="' . $body_css_class . '"' : null !!}>
    <!--@if (strpos($_SERVER['REQUEST_URI'], '-demo/') !== false || strpos($_SERVER['SERVER_NAME'], '127.0.0.1') !== false)
<div class="demo-ribbon">
            <span>DEMO</span>
        </div>
@endif-->
    @include('admin.includes.header')
    <div class="container-scroller">
        @include('admin.includes.top-nav')
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_sidebar.html -->
            @include('admin.includes.sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                @include('admin.includes.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
    </div>
    @include('admin.includes.footer-assets')
    @stack('link-scripts')
    @stack('inline-scripts')
</body>

</html>
