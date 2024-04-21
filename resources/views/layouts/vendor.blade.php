<!doctype html>
<html lang="en">
<head>
    <title>GOT - @yield('title', 'Default')</title>
    @include('vendor.includes.head-meta')
    @include('vendor.includes.head-assets')
    @stack('link-styles')
    @stack('inline-styles')
</head>

<body {!! @$body_css_class ? 'class="' . $body_css_class . '"' : null !!}>
    <!--wrapper-->
	<div class="wrapper">
        @include('vendor.includes.sidebar')
        @include('vendor.includes.header')
        <!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				@yield('content')
			</div>
		</div>
		<!--end page wrapper -->
        @include('vendor.includes.footer')
    </div>
    @include('vendor.includes.footer-assets')
    @stack('link-scripts')
    @stack('inline-scripts')
</body>
</html>