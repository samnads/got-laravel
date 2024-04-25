<!doctype html>
<html lang="en">
<head>
    <title>GOT - @yield('title', 'Default')</title>
    @include('user.includes.head-meta')
    @include('user.includes.head-assets')
    @stack('link-styles')
    @stack('inline-styles')
</head>

<body {!! @$body_css_class ? 'class="' . $body_css_class . '"' : null !!}>
    <!--wrapper-->
	<div class="wrapper">
        @include('user.includes.sidebar')
        @include('user.includes.header')
        <!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				@yield('content')
			</div>
		</div>
		<!--end page wrapper -->
        @include('user.includes.footer')
    </div>
    @include('user.includes.footer-assets')
    @stack('link-scripts')
    @stack('inline-scripts')
</body>
</html>