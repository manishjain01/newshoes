<!DOCTYPE html>
<html lang="en">
       @include('includes.admin.head')
    <body class="skin-blue sidebar-mini">
	    @include('includes.admin.header')
	    @include('includes.admin.message')
	    @include('includes.admin.sidebar')
	    <div class="wrapper">
	    @yield('content')
	    @include('includes.admin.footer')
    </body>
</html>