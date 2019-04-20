<!DOCTYPE html>
<html lang="en">
       @include('includes.frontend.head')
       <body class="preloader-active">

	    @include('includes.frontend.header_inner')
	    @yield('content')
	    @include('includes.frontend.footer')
	    </body>
</html>
