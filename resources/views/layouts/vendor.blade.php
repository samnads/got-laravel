<!doctype html>
<html lang="en">
<head>
    <title>GOT - @yield('title', 'Default')</title>
    @include('shop.includes.head-meta')
    @include('shop.includes.head-assets')
    @stack('link-styles')
    @stack('inline-styles')
</head>

<body {!! @$body_css_class ? 'class="' . $body_css_class . '"' : null !!}>
    <!--wrapper-->
	<div class="wrapper">
        @include('shop.includes.sidebar')
        @include('shop.includes.header')
        <!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				@yield('content')
			</div>
		</div>
		<!--end page wrapper -->
        @include('shop.includes.footer')
    </div>
    @include('shop.includes.footer-assets')
    @stack('link-scripts')
    @stack('inline-scripts')
</body>
</html>